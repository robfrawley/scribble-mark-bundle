<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Component\Parser\Step;

use Scribe\SwimBundle\Parser\Handler\AbstractSwimParserHandlerType;
use SplSubject;

/**
 * Class SwimIndexStep
 */
class SwimIndexStep extends AbstractSwimParserHandlerType
{
    /**
     * render function called on all SwimSteps
     *
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        $levels = $this->subject->getAttr('toc_levels');

        list($string, $index_html, $index_levels) = $this->buildIndex($string, $levels);

        return [
            $string,
            $index_html,
            $index_levels,
        ];
    }

    /**
     * custom update for this step to assign additional attributes
     *
     * @param SplSubject $subject
     * @return $this
     */
    public function update(SplSubject $subject)
    {
        if (!$subject->hasAttr('toc_levels')) {
            throw new \Exception('SwimIndexStep can only be run after SwimTocStep: Cannot find "toc_levels" attribute in subject');
        }

        $this->subject = $subject;

        list($content, $index_html, $index_levels) = $this->render($subject->getWork());

        $subject->setWork($content);
        $subject->setAttr('index_html', $index_html);
        $subject->setAttr('index_levels', $index_levels);

        return $this;
    }

    /**
     * given the TOC, build an index
     *
     * @param  string $content
     * @return string
     */
    private function buildIndex($content, $toc_levels)
    {
        $this->indexTocHeads($toc_levels);

        return [
            $content,
            $this->getTocHtml($toc_levels),
            $toc_levels,
        ];
    }

    /**
     * @param  array $heads passed by reference
     */
    private function indexTocHeads(&$heads)
    {
        usort($heads, function($a, $b) {
            $encoding = mb_internal_encoding();

            return strcmp(
                mb_strtoupper($a['text'], $encoding),
                mb_strtoupper($b['text'], $encoding)
            );
        });

        foreach ($heads as &$h) {
            if (count($h['subs']) > 0) {
                $this->indexTocHeads($h['subs']);
            }
        }
    }

    /**
     * generate the toc html using twig template engine
     *
     * @param  array $toc_heads
     * @return string
     */
    private function getTocHtml(array $toc_heads)
    {
        $engine = $this
            ->getContainer()
            ->get('templating')
        ;

        return $engine->render(
            'ScribeSwimBundle:Index:index.html.twig',
            [
                'toc_heads' => $toc_heads
            ]
        );
    }
}

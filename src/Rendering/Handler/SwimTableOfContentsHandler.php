<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Rendering\Handler;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SwimTableOfContentsHandler.
 */
class SwimTableOfContentsHandler extends AbstractSwimRenderingHandler
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return self::CATEGORY_BLOCK_LEVEL_GENERAL;
    }

    /**
     * @param string $string
     * @param array  $args
     *
     * @return string
     */
    public function render($string, array $args = [])
    {
        $this->stopwatchStart($this->getType(), 'Swim');

        list($string, $toc_html, $toc_levels) = $this->buildToc($string);

        $this->addAttributes([
            'toc_html' => $toc_html,
            'toc_levels' => $toc_levels
        ]);

        $this->stopwatchStop($this->getType());

        return $string;
    }

    /**
     * given the page content, build TOC based on headers found
     *
     * @param  string $content
     * @return string
     */
    private function buildToc($content)
    {
        $pattern = '#<h(?<h>[0-9])>(.*?)</h\k<h>>#i';
        preg_match_all($pattern, $content, $matches);

        $toc_heads          = $this->getTocStructredData($matches);
        $toc_head_first_key = $this->getTocFirstKey($toc_heads);

        foreach (range(1, 10) as $i) {
            $lowest = $this->getTocLowest($toc_heads);
            $this->structureTocByLowest($toc_heads, $toc_head_first_key, $lowest);
        }

        $toc_heads = $this->resetTocArrayKeys($toc_heads);

        return [
            $this->addContentHeaderAnchors($toc_heads, $content),
            $this->getTocHtml($toc_heads),
            $toc_heads,
        ];
    }

    /**
     * structure the matched values into sensible format
     *
     * @param  array $preg_matches
     * @return array
     */
    private function getTocStructredData(array $preg_matches)
    {
        $array = [];

        for ($i = 0; $i < count($preg_matches[0]); $i++) {
            $array[] = [
                'text'  => $preg_matches[2][$i],
                'level' => $preg_matches['h'][$i],
                'id'    => 'anchor-'.strtolower(preg_replace('#[^a-z0-9]#i', '', $preg_matches[2][$i])),
                'subs'  => [],
            ];
        }

        return $array;
    }

    /**
     * get the lowest toc level in top-level head array
     *
     * @param  array $toc_heads
     * @return int
     */
    private function getTocLowest(array $toc_heads)
    {
        $levels = array_map(function($item) {
            return $item['level'];
        }, $toc_heads);

        sort($levels, SORT_NUMERIC);

        return (int) array_pop($levels);
    }

    /**
     * get the first toc element key
     *
     * @param  array $toc_heads
     * @return int
     */
    private function getTocFirstKey(array $toc_heads)
    {
        reset($toc_heads);
        return key($toc_heads);
    }

    /**
     * structure the data based on the level
     *
     * @param  array $toc_heads          assigned by reference
     * @param  int   $toc_head_first_key
     * @param  int   $lowest
     * @return void
     */
    private function structureTocByLowest(array &$toc_heads, $toc_head_first_key, $lowest)
    {
        $toc_head_previous_key = $toc_head_first_key;
        $toc_head_remove_list  = [];

        foreach ($toc_heads as $index => $value) {
            if ($index == $toc_head_first_key) { continue; }
            if ($value['level'] < $lowest) { $toc_head_previous_key = $index; }
            if ($value['level'] == $toc_heads[$toc_head_previous_key]['level']) { continue; }
            if ($value['level'] != $lowest) { continue; }

            $toc_heads[$toc_head_previous_key]['subs'][] = $value;
            $toc_head_remove_list[]                      = $index;
        }

        foreach ($toc_head_remove_list as $index) {
            unset($toc_heads[$index]);
        }
    }

    /**
     * reset array keys
     *
     * @param  array $toc_heads
     * @return array
     */
    private function resetTocArrayKeys(array $toc_heads)
    {
        return array_values($toc_heads);
    }

    /**
     * generate the toc html using twig template engine
     *
     * @param  array $toc_heads
     * @return string
     */
    private function getTocHtml(array $toc_heads)
    {
        $twig = $this->container->get('twig');

        return $twig->render(
            'ScribeSwimBundle:Toc:contents.html.twig',
            [
                'toc_heads' => $toc_heads
            ]
        );
    }

    /**
     * add id anchors to headers for toc to reference
     *
     * @param  array  $toc_heads
     * @param  string $content
     * @return string
     */
    private function addContentHeaderAnchors(array $toc_heads, $content, $prev = null)
    {
        foreach ($toc_heads as $index => $head) {
            if ($prev === null) { $prev = ''; }

            $search  = '<h'.$head['level'].'>'.$head['text'].'</h'.$head['level'].'>';
            $replace = '<h'.$head['level'].' id="'.$head['id'].'">'.$head['text'].'</h'.$head['level'].'>';

            $content = str_replace($search, $replace, $content);

            if (count($head['subs']) > 0) {
                $content = $this->addContentHeaderAnchors($head['subs'], $content, $prev.$index);
            }
        }

        return $content;
    }
}

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

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Scribe\SwimBundle\Component\Parser\SwimInterface,
    Scribe\SwimBundle\Component\Parser\SwimAbstractStep;

/**
 * Class SwimParserQueries
 */
class SwimCalloutStep extends SwimAbstractStep implements SwimInterface, ContainerAwareInterface
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        $renderer = $this
            ->getContainer()
            ->get('varspool_markdown')
        ;

        @preg_match_all('#{~\?:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-warning"><p class="callout-header">Note</p>'.$renderer->render($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        @preg_match_all('#{~\!:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-danger"><p class="callout-header">Key Point</p>'.$renderer->render($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        @preg_match_all('#{~\-:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-info"><p class="callout-header">Tip</p>'.$renderer->render($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        return $string;
    }
}
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
use \Sundown;

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
        $matched = [];
        @preg_match_all('#{~\?:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-warning callout-no-header">'.((new Sundown($matches[1][$i]))->toHtml()).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\!:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-danger callout-no-header">'.((new Sundown($matches[1][$i]))->toHtml()).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\-:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-info callout-no-header">'.((new Sundown($matches[1][$i]))->toHtml()).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\+:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-success callout-no-header">'.((new Sundown($matches[1][$i]))->toHtml()).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\??:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-warning"><p class="callout-header">Note</p>'.((new Sundown($matches[1][$i]))->toHtml()).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\!!:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-danger"><p class="callout-header">Key Point</p>'.((new Sundown($matches[1][$i]))->toHtml()).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\-\-:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-info"><p class="callout-header">Tip</p>'.((new Sundown($matches[1][$i]))->toHtml()).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\+\+:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-success"><p class="callout-header">Success</p>'.((new Sundown($matches[1][$i]))->toHtml()).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        return $string;
    }
}
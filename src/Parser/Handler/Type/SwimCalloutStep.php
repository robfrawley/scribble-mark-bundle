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
use \Sundown;

/**
 * Class SwimParserQueries
 */
class SwimCalloutStep extends AbstractSwimParserHandlerType
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        $markdown = $this->getContainer()->get('kwattro_markdown');

        $matched = [];
        @preg_match_all('#{~\?:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-warning callout-no-header">'.$markdown->render($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\!:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-danger callout-no-header">'.$markdown->render($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\-:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-info callout-no-header">'.$markdown->render($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\+:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-success callout-no-header">'.$markdown->render($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\?\?:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-warning"><p class="callout-header">Note</p>'.$markdown->render($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\!!:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-danger"><p class="callout-header">Key Point</p>'.$markdown->render($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\-\-:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-info"><p class="callout-header">Tip</p>'.$markdown->render($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\+\+:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-success"><p class="callout-header">Success</p>'.$markdown->render($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        return $string;
    }
}

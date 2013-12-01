<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\LearningBundle\Utility\Parser\Swim;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;
use Scribe\SharedBundle\Utility\Filters\String,
    Scribe\LearningBundle\Utility\Parser\ParserInterface;

/**
 * Class SwimParserBootstrapCollapse
 */
class SwimParserBootstrapCollapse extends SwimParserObserver implements ParserInterface, ContainerAwareInterface
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        $string = $this->doIndependentCollapses($string);
        $string = $this->doSingleCollapses($string);

        return $string;
    }

    private function doSingleCollapses($string = '')
    {
        $string = str_ireplace('{~collapse-single:end}', '</div>', $string);

        $matches = [];
        @preg_match_all('#{~collapse-single:start:(.*?)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original = $matches[0][$i];
                $title    = $matches[1][$i];
                $target   = String::alphanumericOnly($matches[1][$i]);
                $replace  = '<div class="collapse-single_'.$target.' collapsable collapse">';
                $string   = str_replace($original, $replace, $string);
            }
        }

        $matches = [];
        @preg_match_all('#{~collapse-single:toggle:(.*?)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original = $matches[0][$i];
                $title    = $matches[1][$i];
                $target   = String::alphanumericOnly($matches[1][$i]);
                $replace = '<span class="collapsable-toggle collapsed" data-toggle="collapse" data-target=".collapse-single_'.$target.'"><span class="icon-for-open icon-chevron-sign-up icon-fixed-width"> </span><span class="icon-for-closed icon-chevron-sign-down icon-fixed-width"> </span>'.$title.'</span>';
                $string = str_replace($original, $replace, $string);
            }
        }

        return $string;
    }

    private function doIndependentCollapses($string = '')
    {
        $string = str_ireplace('{~collapse:end}', '</div>', $string);

        $matches = [];
        @preg_match_all('#{~collapse:start:open:(.*?)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original = $matches[0][$i];
                $title    = $matches[1][$i];
                $target   = String::alphanumericOnly($matches[1][$i]);
                $replace  = '<div id="T_'.$target.'" class="collapsable collapse in">';
                $string   = str_replace($original, $replace, $string);
            }
        }

        $matches = [];
        @preg_match_all('#{~collapse:start:(.*?)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original = $matches[0][$i];
                $title    = $matches[1][$i];
                $target   = String::alphanumericOnly($matches[1][$i]);
                $replace  = '<div id="T_'.$target.'" class="collapsable collapse">';
                $string   = str_replace($original, $replace, $string);
            }
        }

        $matches = [];
        @preg_match_all('#{~collapse:toggle:(.*?)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original = $matches[0][$i];
                $title    = $matches[1][$i];
                $target   = String::alphanumericOnly($matches[1][$i]);
                $replace = '<span class="collapsable-toggle collapsed" data-toggle="collapse" data-target="#T_'.$target.'"><span class="icon-for-open icon-chevron-sign-up icon-fixed-width"> </span><span class="icon-for-closed icon-chevron-sign-down icon-fixed-width"> </span>'.$title.'</span>';
                $string = str_replace($original, $replace, $string);
            }
        }

        return $string;
    }
}
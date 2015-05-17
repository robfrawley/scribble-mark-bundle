<?php

/*
 * This file is part of the Scribe Swim Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Rendering\Handler;

use Scribe\Utility\Filter\StringFilter;

/**
 * Class SwimBootstrapCollapseHandler.
 */
class SwimBootstrapCollapseHandler extends AbstractSwimRenderingHandler
{
    /**
     * @return string
     */
    public function getCategory()
    {
        return self::CATEGORY_BOOTSTRAP_COMPONENTS;
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

        $string = $this->doIndependentCollapses($string);
        $string = $this->doSingleCollapses($string);

        $this->stopwatchStop($this->getType());

        return $string;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    private function doSingleCollapses($string = '')
    {
        $string = str_ireplace('{~collapse-single:end}', '</div>', $string);

        $matches = [];
        @preg_match_all('#{~collapse-single:start:(.*?)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original = $matches[0][$i];
                $title    = $matches[1][$i];
                $target   = StringFilter::alphanumericOnly($matches[1][$i]);
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
                $target   = StringFilter::alphanumericOnly($matches[1][$i]);
                $replace = '<span class="collapsable-toggle collapsed" data-toggle="collapse" data-target=".collapse-single_'.$target.'"><span class="icon-for-open icon-chevron-sign-up icon-fixed-width"> </span><span class="icon-for-closed icon-chevron-sign-down icon-fixed-width"> </span>'.$title.'</span>';
                $string = str_replace($original, $replace, $string);
            }
        }

        return (string) $string;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    private function doIndependentCollapses($string = '')
    {
        $string = str_ireplace('{~collapse:end}', '</div>', $string);

        $matches = [];
        @preg_match_all('#{~collapse:start:open:(.*?)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original = $matches[0][$i];
                $title    = $matches[1][$i];
                $target   = StringFilter::alphanumericOnly($matches[1][$i]);
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
                $target   = StringFilter::alphanumericOnly($matches[1][$i]);
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
                $target   = StringFilter::alphanumericOnly($matches[1][$i]);
                $replace = '<span class="collapsable-toggle collapsed" data-toggle="collapse" data-target="#T_'.$target.'">'.$title.'</span>';
                $string = str_replace($original, $replace, $string);
            }
        }

        return (string) $string;
    }
}

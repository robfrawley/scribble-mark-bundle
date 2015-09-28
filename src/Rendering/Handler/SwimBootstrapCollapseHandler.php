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

use Scribe\Wonka\Utility\Filter\StringFilter;

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
        $string = $this->doIndependentCollapses($string);
        $string = $this->doSingleCollapses($string);

        return $string;
    }

    /**
     * @param string $string
     *
     * @return string
     */
    private function doSingleCollapses($string = '')
    {
        $string = str_ireplace('{~collapse-single:end}', '', $string);

        $matches = [];
        @preg_match_all('#{~collapse-single:start:(.*?)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original = $matches[0][$i];
                $title = $matches[1][$i];
                $target = StringFilter::alphanumericOnly($matches[1][$i]);
                $replace = '';
                $string = str_replace($original, $replace, $string);
            }
        }

        $matches = [];
        @preg_match_all('#{~collapse-single:toggle:(.*?)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original = $matches[0][$i];
                $title = $matches[1][$i];
                $target = StringFilter::alphanumericOnly($matches[1][$i]);
                $replace = $title;
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
        $string = str_ireplace('{~collapse:end}', '', $string);

        $matches = [];
        @preg_match_all('#{~collapse:start:open:(.*?)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original = $matches[0][$i];
                $title = $matches[1][$i];
                $target = StringFilter::alphanumericOnly($matches[1][$i]);
                $replace = '';
                $string = str_replace($original, $replace, $string);
            }
        }

        $matches = [];
        @preg_match_all('#{~collapse:start:(.*?)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original = $matches[0][$i];
                $title = $matches[1][$i];
                $target = StringFilter::alphanumericOnly($matches[1][$i]);
                $replace = '';
                $string = str_replace($original, $replace, $string);
            }
        }

        $matches = [];
        @preg_match_all('#{~collapse:toggle:(.*?)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original = $matches[0][$i];
                $title = $matches[1][$i];
                $target = StringFilter::alphanumericOnly($matches[1][$i]);
                $replace = $title;
                $string = str_replace($original, $replace, $string);
            }
        }

        return (string) $string;
    }
}

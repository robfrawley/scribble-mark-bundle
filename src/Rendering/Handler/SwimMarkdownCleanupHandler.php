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

/**
 * Class SwimMarkdownCleanupHandler.
 */
class SwimMarkdownCleanupHandler extends AbstractSwimRenderingHandler
{
    /**
     * @return string
     */
    public function getCategory()
    {
        return self::CATEGORY_MARKDOWN_GENERAL;
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

        @preg_match_all('#<p>(</.*>)</p>#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $string = str_ireplace($matches[0][$i], $matches[1][$i], $string);
            }
        }

        $matches = [];
        @preg_match_all('#<p></p>#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $string = str_ireplace($matches[0][$i], '', $string);
            }
        }

        $matches = [];
        @preg_match_all('#<p>(<div id="T_.*?" class=".*?collapse.*?">)</p>#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $string = str_ireplace($matches[0][$i], $matches[1][$i], $string);
            }
        }

        $this->stopwatchStop($this->getType());

        return $string;
    }
}

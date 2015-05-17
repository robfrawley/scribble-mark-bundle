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
 * Class SwimParagraphLeadHandler.
 */
class SwimParagraphLeadHandler extends AbstractSwimRenderingHandler
{
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

        @preg_match_all('#<([^>])>\*\*\*\*(.*)</(\1)>#i', $string, $matches);
        if (0 < count($matches)) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $replace = '<'.$matches[1][$i].' class="lead">'.$matches[2][$i].'</'.$matches[1][$i].'>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        @preg_match_all('#<([^>])>\((.*)\)</(\1)>#i', $string, $matches);
        if (0 < count($matches)) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $replace = '<'.$matches[1][$i].' class="lead">'.$matches[2][$i].'</'.$matches[1][$i].'>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $this->stopwatchStop($this->getType());

        return $string;
    }
}

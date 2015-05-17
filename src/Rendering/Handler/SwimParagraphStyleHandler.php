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
 * Class SwimParagraphStyleHandler.
 */
class SwimParagraphStyleHandler extends AbstractSwimRenderingHandler
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

        @preg_match_all('#<\s([^\|]*?)\|(.*)#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $pullquote   = $matches[1][$i];
                $para = $matches[2][$i];
                $replace = '<p class="has-pullquote" data-pullquote="'.$pullquote.'">'.$para.'</p>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $this->stopwatchStop($this->getType());

        return $string;
    }
}

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
 * Class SwimCharacterStyleHandler.
 */
class SwimCharacterStyleHandler extends AbstractSwimRenderingHandler
{
    /**
     * @var \ParsedownExtra
     */
    private $parsedown;

    /**
     * Construct handler by creating parsedown instance.
     */
    public function __construct()
    {
        $this->parsedown = new \ParsedownExtra();
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return self::CATEGORY_INLINE_LEVEL_GENERAL;
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

        @preg_match_all('#{~sm:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $replace = '<small class="text-muted">'.$this->parsedown->text($matches[1][$i]).'</small>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        @preg_match_all('#{~scml:([^}]*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $replace = '<span class="scml">'.$matches[1][$i].'</span>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        @preg_match_all('#{~app-menu:([^}]*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $replace = '<span class="app-menu">'.$matches[1][$i].'</span>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $this->stopwatchStop($this->getType());

        return $string;
    }
}

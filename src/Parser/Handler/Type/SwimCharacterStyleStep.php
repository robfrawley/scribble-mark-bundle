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
 * Class SwimParserCharacterStyles
 */
class SwimCharacterStyleStep extends AbstractSwimParserHandlerType
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        $markdown = $this->getContainer()->get('kwattro_markdown');

        @preg_match_all('#{~sm:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<small class="text-muted">'.$markdown->render($matches[1][$i]).'</small>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        @preg_match_all('#{~scml:([^}]*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<span class="scml">'.$matches[1][$i].'</span>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        @preg_match_all('#{~app-menu:([^}]*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<span class="app-menu">'.$matches[1][$i].'</span>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        return $string;
    }
}

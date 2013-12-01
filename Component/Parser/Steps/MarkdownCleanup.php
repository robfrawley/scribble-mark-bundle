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
 * Class SwimParserHtmlCleanup
 */
class SwimParserHtmlCleanup extends SwimParserObserver implements ParserInterface, ContainerAwareInterface
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        @preg_match_all('#<p>(</.*>)</p>#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $string = str_ireplace($matches[0][$i], $matches[1][$i], $string);
            }
        }

        $matches = [];
        @preg_match_all('#<p></p>#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $string = str_ireplace($matches[0][$i], $matches[1][$i], $string);
            }
        }

        $matches = [];
        @preg_match_all('#<p>(<div id="T_.*?" class=".*?collapse.*?">)</p>#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $string = str_ireplace($matches[0][$i], $matches[1][$i], $string);
            }
        }

        return $string;
    }
}
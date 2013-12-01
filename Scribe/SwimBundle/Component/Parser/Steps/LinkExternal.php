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
use Scribe\SharedBundle\Utility\Filters\String;
use Scribe\LearningBundle\Utility\Parser\ParserInterface;

/**
 * Class SwimParserInternalLink
 */
class SwimParserInternalLink extends SwimParserObserver implements ParserInterface, ContainerAwareInterface
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        $matches = [];
        $pattern = '#{~a\-in:([^ ]*?)( (.*?))?}#i';
        @preg_match_all($pattern, $string, $matches);

        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {

                $original = $matches[0][$i];
                $uri      = $matches[1][$i];
                if (substr($uri, 0, 4) !== 'http') {
                    $url = 'https://wfd.io'.$uri;
                } else {
                    $url = $uri;
                }
                $title    = empty($matches[3][$i]) ? $url : $matches[3][$i];
                $replace  = '<i class="fa fa-link a-external-icon"></i> <a class="a-external" href="'.$url.'">'.$title.'</a>';

                $string = str_replace($original, $replace, $string);
            }
        }

        return $string;
    }
}

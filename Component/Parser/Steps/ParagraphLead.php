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
 * Class SwimParserQueries
 */
class SwimParserLeadParagraph extends SwimParserObserver implements ParserInterface, ContainerAwareInterface
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        $renderer = $this
            ->getContainer()
            ->get('varspool_markdown')
        ;

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

        return $string;
    }
}
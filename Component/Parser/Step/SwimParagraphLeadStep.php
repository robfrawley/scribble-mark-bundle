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

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Scribe\SwimBundle\Component\Parser\SwimInterface,
    Scribe\SwimBundle\Component\Parser\SwimAbstractStep;
use \Sundown;

/**
 * Class SwimParserQueries
 */
class SwimParagraphLeadStep extends SwimAbstractStep implements SwimInterface, ContainerAwareInterface
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        $markdown = $this->getContainer()->get('kwattro_markdown');

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
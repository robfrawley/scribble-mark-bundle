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

/**
 * Class SwimParserPreBlock
 */
class SwimCodeStep extends SwimAbstractStep implements SwimInterface, ContainerAwareInterface
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        @preg_match_all('#<code((.*\n)*?)<#i', $string, $matches);
        print_r($matches);
        if (0 < count($matches[0])) {

            for ($i = 0; $i < count($matches[0]); $i++) {

                $original = $matches[0][$i];
                $replace  = '<code><pre>'.htmlentities($matches[1][$i]).'</pre></code>';

                $string = str_replace($original, $replace, $string);
            }
        }

        return $string;
    }
}
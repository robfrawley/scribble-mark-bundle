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
 * SwimLinkInternalStep
 * Handles all internal (same domain) links
 */
class SwimLinkInternalStep extends SwimAbstractStep implements SwimInterface, ContainerAwareInterface
{
    /**
     * @param  null $work
     * @return string
     */
    public function render($work = null)
    {
        $pattern = '#{~a-internal:([^ ]*?)( (.*?))?}#i';
        $matches = [];
        @preg_match_all($pattern, $string, $matches);

        if (count($matches[0]) > 0) {

            for ($i = 0; $i < count($matches[0]); $i++) {

                $original = $matches[0][$i];
                $url      = $matches[1][$i];
                $title    = empty($matches[3][$i]) ? $url : $matches[3][$i];
                $replace  = '<a href="'.$url.'">'.$title.'</a>';
                $work     = str_replace($original, $replace, $work);
            }
        }

        return $work;
    }
}
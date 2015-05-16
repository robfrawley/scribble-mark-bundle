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
 * Class SwimBootstrapTooltipHandler.
 */
class SwimBootstrapTooltipHandler extends AbstractSwimRenderingHandler
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null, array $args = [])
    {
        @preg_match_all('#{~tt:(.*?) (.*?)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<span class="tooltipie" data-toggle="tooltip" title="'.$matches[2][$i].'">'.$matches[1][$i].'</span>';
                $string  = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        return $string;
    }
}
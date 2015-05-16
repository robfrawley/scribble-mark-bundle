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
 * Class SwimBootstrapColumnHandler.
 */
class SwimBootstrapColumnHandler extends AbstractSwimRenderingHandler
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null, array $args = [])
    {
        $string = str_ireplace('{~row:start}', '<div class="row">', $string);
        $string = str_ireplace('{~row:end}', '</div>', $string);

        $matches = [];
        @preg_match_all('#{~col:start:([0-9]*?)?}#i', $string, $matches);

        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original    = $matches[0][$i];
                if (empty($matches[1][$i]) && $matches[1][$i] != 0) {
                    $col_span = 12;
                } else {
                    $col_span = 12 / $matches[1][$i];
                }
                $replace = '<div class="col-md-'.$col_span.'">';
                $string = str_replace($original, $replace, $string);
            }
        }

        if (count($matches) > 0) {
            $string = str_ireplace('{~col:end}', '</div>', $string);
        }

        return $string;
    }
}

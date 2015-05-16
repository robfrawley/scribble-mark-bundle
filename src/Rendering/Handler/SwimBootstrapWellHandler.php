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
 * Class SwimBootstrapWellHandler.
 */
class SwimBootstrapWellHandler extends AbstractSwimRenderingHandler
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null, array $args = [])
    {
        $string = str_ireplace('{~well:start}', '<div class="well">', $string);
        $string = str_ireplace('{~well:end}',   '</div>',             $string);

        return $string;
    }
}

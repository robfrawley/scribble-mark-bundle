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
 * Class SwimMarkdownHandler.
 */
class SwimMarkdownHandler extends AbstractSwimRenderingHandler
{
    /**
     * @param  null $string
     * @return mixed|null
     */
    public function render($string = null, array $args = [])
    {
    	$markdown = $this->getContainer()->get('kwattro_markdown');

        return $markdown->render($string);
    }
}

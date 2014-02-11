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
 * Class SwimParserMarkdown
 */
class SwimMarkdownStep extends SwimAbstractStep implements SwimInterface, ContainerAwareInterface
{
    /**
     * @param  null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        return (new Sundown($string))->toHtml();
    }
}
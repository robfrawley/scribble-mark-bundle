<?php

/*
 * This file is part of the Scribe Swim Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Rendering\Handler;

use Scribe\Component\DependencyInjection\Compiler\CompilerPassHandlerInterface;
use Scribe\MantleBundle\Templating\Generator\RendererInterface;
use Scribe\SwimBundle\Rendering\Manager\SwimRenderingManagerInterface;

/**
 * Class SwimRendererHandlerInterface.
 */
interface SwimRenderingHandlerInterface extends RendererInterface, CompilerPassHandlerInterface
{
    /**
     * @param SwimRenderingManagerInterface $manager
     *
     * @return $this
     */
    public function chainRendering(SwimRenderingManagerInterface $manager);

    /**
     * @return array
     */
    public function getAttributes();

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes = []);

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function addAttributes(array $attributes = []);
}

/* EOF */

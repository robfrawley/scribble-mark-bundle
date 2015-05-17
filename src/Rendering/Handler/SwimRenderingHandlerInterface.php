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
use Scribe\Component\DependencyInjection\Container\ContainerAwareInterface;
use Scribe\MantleBundle\Templating\Generator\RendererInterface;
use Scribe\SwimBundle\Rendering\Manager\SwimRenderingManagerInterface;

/**
 * Class SwimRendererHandlerInterface.
 */
interface SwimRenderingHandlerInterface extends RendererInterface, CompilerPassHandlerInterface
{
    /**
     * @var string
     */
    const CATEGORY_BLOCK_EXCLUDES = 'block_excludes';

    /**
     * @var string
     */
    const CATEGORY_BLOCK_RESTRICTIONS = 'block_restrictions';

    /**
     * @var string
     */
    const CATEGORY_BLOCK_LEVEL_GENERAL = 'block_level_general';

    /**
     * @var string
     */
    const CATEGORY_INLINE_LEVEL_GENERAL = 'inline_level_general';

    /**
     * @var string
     */
    const CATEGORY_LINK_INTERNAL_ROUTING = 'link_internal_routes';

    /**
     * @var string
     */
    const CATEGORY_LINK_DECORATING = 'link_decorating';

    /**
     * @var string
     */
    const CATEGORY_MARKDOWN_GENERAL = 'markdown_general';

    /**
     * @var string
     */
    const CATEGORY_MARKDOWN_EXTRA = 'markdown_extra';

    /**
     * @var string
     */
    const CATEGORY_BOOTSTRAP_COMPONENTS = 'bootstrap_components';

    /**
     * @var string
     */
    const CATEGORY_PROFILER = 'profiler';

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

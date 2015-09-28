<?php

/*
 * This file is part of the Scribe Cache Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Rendering\Manager\Factory;

use Scribe\WonkaBundle\Component\DependencyInjection\Container\ServiceFinder;
use Scribe\SwimBundle\Rendering\Manager\SwimRenderingManagerInterface;

/**
 * Class SwimRendererFactory.
 */
class SwimRendererFactory
{
    /**
     * Service name of Swim renderer without caching.
     *
     * @var string
     */
    const SWIM_RENDERER_CACHING_DISABLED = 's.swim.renderer_caching_disabled';

    /**
     * Service name of Swim renderer with caching.
     *
     * @var string
     */
    const SWIM_RENDERER_CACHING_ENABLED = 's.swim.renderer_caching_enabled';

    /**
     * @param ServiceFinder $serviceFinder
     * @param bool          $cachingEnabled
     *
     * @return SwimRenderingManagerInterface
     */
    public static function getRenderer(ServiceFinder $serviceFinder, $cachingEnabled = true)
    {
        if (true === $cachingEnabled) {
            return $serviceFinder(self::SWIM_RENDERER_CACHING_ENABLED);
        }

        return $serviceFinder(self::SWIM_RENDERER_CACHING_DISABLED);
    }
}

/* EOF */

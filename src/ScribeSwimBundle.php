<?php

/*
 * This file is part of the Scribe Swim Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle;

use Scribe\SwimBundle\DependencyInjection\Compiler\SwimRendererCompilerPass;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Class ScribeSwimBundle.
 */
class ScribeSwimBundle extends Bundle
{
    /**
     * Build the container for Swim bundle!
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new SwimRendererCompilerPass());
    }
}

/* EOF */

<?php

/*
 * This file is part of the Scribe Symfony Swim Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\DependencyInjection\Compiler;

use Scribe\MantleBundle\DependencyInjection\Compiler\AbstractCompilerPass;

/**
 * Class SwimRendererCompilerPass.
 */
class SwimRendererCompilerPass extends AbstractCompilerPass
{
    /**
     * Return the name of the service that handles registering the handlers (the chain manager)
     *
     * @return string
     */
    protected function getChainServiceName()
    {
        return 's.swim.renderer_chain.registrar';
    }

    /**
     * Return the name of the service tag to attach to the chain manager (the handlers)
     *
     * @return string
     */
    protected function getHandlerTagName()
    {
        return 'swim.renderer_handler';
    }
}

/* EOF */

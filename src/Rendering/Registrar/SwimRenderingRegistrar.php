<?php

/*
 * This file is part of the Scribe Swim Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Rendering\Registrar;

use Scribe\Component\DependencyInjection\Compiler\AbstractCompilerPassChain;
use Scribe\Component\DependencyInjection\Container\ContainerAwareTrait;
use Scribe\SwimBundle\Rendering\Handler\SwimRenderingHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SwimRenderingRegistrar.
 */
class SwimRenderingRegistrar extends AbstractCompilerPassChain implements SwimRenderingRegistrarInterface
{
    use ContainerAwareTrait;

    /**
     * Construct object with empty handlers array.
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct(
            ['restrictions' => ['Scribe\SwimBundle\Rendering\Handler\SwimRenderingHandlerInterface']]
        );

        $this->setContainer($container);

        $this->setAddHandlerCallable(function(&$handlerCollection, $handler, $priority, $extra) use ($container) {
            $handler->setContainer($container);
            $handlerCollection[$priority] = $handler;

            if (true === is_array($extra) && true === array_key_exists('priority_end', (array) $extra)) {
                $handlerCollection[(100 - $extra['priority_end'])] = $handler;
            }
        });
    }
}

/* EOF */

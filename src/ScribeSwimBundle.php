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

use Scribe\SwimBundle\DependencyInjection\Compiler\Pass\RendererCompilerPass;
use Scribe\WonkaBundle\Component\Bundle\AbstractCompilerAwareBundle;

/**
 * Class ScribeSwimBundle.
 */
class ScribeSwimBundle extends AbstractCompilerAwareBundle
{
    /**
     * {@inheritdoc}
     */
    public function getCompilerPassInstances()
    {
        return [
            new RendererCompilerPass(),
        ];
    }
}

/* EOF */

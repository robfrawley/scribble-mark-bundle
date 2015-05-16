<?php

/*
 * This file is part of the Scribe Cache Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Scribe\Component\DependencyInjection\AbstractExtension;

/**
 * Class ScribeSwimExtension.
 */
class ScribeSwimExtension extends AbstractExtension
{
    /**
     * Load the configuration from the yaml config based on definitions defined
     * within the {@see Configuration.php} file.
     *
     * @param array            $configs   the configs to load
     * @param ContainerBuilder $container symfony container for configurations
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $this->autoLoad($configs, $container, new Configuration(), 's.swim');
    }
}

/* EOF */

<?php

/*
 * This file is part of the Scribe Cache Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Tests;

use PHPUnit_Framework_TestCase;
use ReflectionClass;
use Scribe\SwimBundle\ScribeSwimBundle;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ScribeSwimBundleTest.
 */
class ScribeSwimBundleTest extends PHPUnit_Framework_TestCase
{
    const FULLY_QUALIFIED_CLASS_NAME = 'Scribe\SwimBundle\ScribeSwimBundle';

    private static $container;

    public function setUp()
    {
        $kernel = new \AppKernel('test', true);
        $kernel->boot();
        static::$container = $kernel->getContainer();
    }

    public function getNewBundle()
    {
        return new ScribeSwimBundle();
    }

    public function getReflection()
    {
        return new ReflectionClass(self::FULLY_QUALIFIED_CLASS_NAME);
    }

    public function testCanBuildContainer()
    {
        static::assertTrue((static::$container instanceof Container));
    }

    public function testCanAccessContainerServices()
    {
        static::assertTrue(static::$container->has('s.swim'));
    }

    public function testCanApplyCompilerPass()
    {
        static::assertTrue(static::$container->has('s.swim.renderer_chain.registrar'));

        $methodChain = static::$container->get('s.swim.renderer_chain.registrar');

        static::assertNotEquals([], $methodChain->getHandlerCollection());
        static::assertTrue($methodChain->hasHandlerCollection());
        static::assertEquals(20, count($methodChain->getHandlerCollection()));
    }

    public function tearDown()
    {
        if (!static::$container instanceof ContainerInterface) {
            return;
        }

        $cacheDir = static::$container->getParameter('kernel.cache_dir');

        if (true === is_dir($cacheDir)) {
            $this->removeDirectoryRecursive($cacheDir);
        }
    }

    public function removeDirectoryRecursive($path)
    {
        $files = glob($path . '/*');

        foreach ($files as $file) {
            is_dir($file) ? $this->removeDirectoryRecursive($file) : unlink($file);
        }

        rmdir($path);
    }
}

/* EOF */

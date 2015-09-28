<?php

/*
 * This file is part of the Scribe Cache Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Tests\Rendering\Manager;

use Scribe\WonkaBundle\Utility\TestCase\KernelTestCase;

/**
 * Class SwimRenderingManagerTest.
 */
class SwimRenderingManagerTest extends KernelTestCase
{
    public function testSwimManagerInstance()
    {
        $manager = static::$staticContainer->get('s.swim');

        static::assertInstanceOf('Scribe\SwimBundle\Rendering\Manager\SwimRenderingManagerCached', $manager);
    }

    public function testSwimManagerRendering()
    {
        $manager = static::$staticContainer->get('s.swim');
        $swim = "# Header 1\n\nSome text.\n\n## Header 2\n\nOther text.";
        $expected = '<h1 id="anchor-header1">Header 1</h1>
<p>Some text.</p>
<h2 id="anchor-header2">Header 2</h2>
<p>Other text.</p>';

        $result = $manager->render($swim);

        static::assertEquals($expected, $result);
    }

    public function testSwimManagerRenderingAvertCached()
    {
        $manager = static::$staticContainer->get('s.swim');

        $rand1 = mt_rand(10000, 40000);
        $rand2 = mt_rand(50000, 100000);

        $swim = "# Header 1\n\nRandom number: ".$rand1.".\n\n## Header 2\n\nRandom number: ".$rand2.'.';
        $expected = '<h1 id="anchor-header1">Header 1</h1>
<p>Random number: '.$rand1.'.</p>
<h2 id="anchor-header2">Header 2</h2>
<p>Random number: '.$rand2.'.</p>';

        $result = $manager->render($swim);

        static::assertEquals($expected, $result);
    }

    public function testSwimManagerFullPage()
    {
        $manager = static::$staticContainer->get('s.swim');
        $dirPath = realpath(static::$staticContainer->getParameter('kernel.root_dir').'/../../../app/config/shared_public/tests/fixtures/ScribeSwimBundle/Rendering/Manager/');

        $content_swim = file_get_contents($dirPath.'/scml.swim');
        $content_html = file_get_contents($dirPath.'/scml.html');

        $result = $manager->render($content_swim);

        static::assertEquals($content_html, $result);
    }
}

/* EOF */

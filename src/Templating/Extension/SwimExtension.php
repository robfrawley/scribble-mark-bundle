<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Templating\Extension;

use Scribe\MantleBundle\Templating\Twig\AbstractTwigExtension;
use Scribe\SwimBundle\Rendering\Manager\SwimRenderingManagerInterface;

/**
 * SwimExtension.
 */
class SwimExtension extends AbstractTwigExtension
{
    /**
     * @var SwimRenderingManagerInterface
     */
    private $manager;

    /**
     * @param SwimRenderingManagerInterface $manager
     */
    public function __construct(SwimRenderingManagerInterface $manager)
    {
        parent::__construct();

        $this->manager = $manager;

        $this->enableOptionHtmlSafe();

        $this->addFunction('swim', [$this, 'swimGeneral']);
        $this->addFilter('swim', [$this, 'swimGeneral']);
        $this->addFilter('swimgeneral', [$this, 'swimGeneral']);
        $this->addFilter('swimlearning', [$this, 'swimLearning']);
        $this->addFilter('swimblog', [$this, 'swimBlog']);
        $this->addFilter('swimbook', [$this, 'swimBook']);
        $this->addFilter('swimdocs', [$this, 'swimDocs']);
    }

    /**
     * @param  $content string
     *
     * @return string
     */
    public function swimGeneral($content)
    {
        return $this->manager->render($content);
    }

    /**
     * @param  $content string
     *
     * @return string
     */
    public function swimDocs($content)
    {
        return $this->manager->render($content);
    }

    /**
     * @param  $content string
     *
     * @return string
     */
    public function swimLearning($content)
    {
        return $this->manager->render($content);
    }

    /**
     * @param  $content string
     *
     * @return string
     */
    public function swimBlog($content)
    {
        return $this->manager->render($content);
    }

    /**
     * @param  $content string
     *
     * @return string
     */
    public function swimBook($content)
    {
        return $this->manager->render($content);
    }
}

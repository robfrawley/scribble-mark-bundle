<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Rendering\Handler;

/**
 * Class SwimMarkdownHandler.
 */
class SwimMarkdownHandler extends AbstractSwimRenderingHandler
{
    /**
     * @var \ParsedownExtra
     */
    private $parsedown;

    /**
     * Construct handler by creating parsedown instance.
     */
    public function __construct()
    {
        $this->parsedown = new \ParsedownExtra();
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return self::CATEGORY_MARKDOWN_EXTRA;
    }

    /**
     * @param string $string
     * @param array  $args
     *
     * @return string
     */
    public function render($string, array $args = [])
    {
        $this->stopwatchStart($this->getType(), 'Swim');

        $string = $this->parsedown->text($string);

        $this->stopwatchStop($this->getType());

        return $string;
    }
}

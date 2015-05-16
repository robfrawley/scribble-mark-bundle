<?php

/*
 * This file is part of the Scribe Swim Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Rendering\Manager;

use Scribe\MantleBundle\Templating\Generator\RendererInterface;

/**
 * Class SwimRendererManagerInterface.
 */
interface SwimRenderingManagerInterface
{
    /**
     * @return string|null
     */
    public function getOriginal();

    /**
     * @param string $original
     *
     * @return $this
     */
    public function setOriginal($original);

    /**
     * @return string|null
     */
    public function getWork();

    /**
     * @param string $work
     *
     * @return $this
     */
    public function setWork($work);

    /**
     * @return string|null
     */
    public function getDone();

    /**
     * @param string $done
     *
     * @return $this
     */
    public function setDone($done);

    /**
     * @return array
     */
    public function getAttributes();

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes = []);

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function addAttributes(array $attributes = []);

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setAttribute($key, $value);

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getAttribute($key);

    /**
     * @param string $string
     * @param string $name
     *
     * @return mixed
     */
    public function render($string, $name = null);
}

/* EOF */

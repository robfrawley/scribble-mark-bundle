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

use Scribe\SwimBundle\DependencyInjection\Compiler\Registrar\RendererCompilerRegistrar;

/**
 * Class SwimRenderingManager.
 */
class SwimRenderingManager implements SwimRenderingManagerInterface
{
    /**
     * @var string
     */
    private $original;

    /**
     * @var string
     */
    private $work;

    /**
     * @var string
     */
    private $done;

    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @var SwimRenderingRegistrar
     */
    protected $registrar;

    /**
     * @param SwimRenderingRegistrarInterface $registrar
     */
    public function __construct(RendererCompilerRegistrar $registrar)
    {
        $this->registrar = $registrar;
    }

    /**
     * @return string
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * @param string $original
     *
     * @return $this
     */
    public function setOriginal($original)
    {
        $this->original = $original;

        return $this;
    }

    /**
     * @return string
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * @param string $work
     *
     * @return $this
     */
    public function setWork($work)
    {
        $this->work = $work;

        return $this;
    }

    /**
     * @return string
     */
    public function getDone()
    {
        return $this->done;
    }

    /**
     * @param string $done
     *
     * @return $this
     */
    public function setDone($done)
    {
        $this->done = $done;

        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function setAttributes(array $attributes = [])
    {
        $this->attributes = $attributes;

        return $this;
    }

    /**
     * @param array $attributes
     *
     * @return $this
     */
    public function addAttributes(array $attributes = [])
    {
        $this->attributes = array_merge(
            (array) $this->attributes,
            (array) $attributes
        );
    }

    /**
     * @param string $key
     * @param mixed  $value
     *
     * @return $this
     */
    public function setAttribute($key, $value)
    {
        $this->attributes[(string) $key] = $value;

        return $this;
    }

    /**
     * @param string $key
     *
     * @return mixed
     */
    public function getAttribute($key)
    {
        if (true === array_key_exists((string) $key, $this->attributes)) {
            return $this->attributes[(string) $key];
        }

        return;
    }

    /**
     * @param string $string
     * @param string $name
     *
     * @return mixed
     */
    public function render($string, $name = null)
    {
        $this->setAttributes([]);
        $this->setOriginal($string);
        $this->setWork($string);

        foreach ($this->registrar as $r) {
            $this->setWork($r->render($this->getWork()));
            $this->addAttributes((array) $r->getAttributes());
        }

        $this->setDone($this->getWork());

        return $this->getDone();
    }
}

/* EOF */

<?php

/*
 * This file is part of the Scribe Symfony Swim Bundle.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Rendering\Handler;

use Scribe\SwimBundle\Rendering\Manager\SwimRenderingManagerInterface;
use Scribe\Wonka\Utility\ClassInfo;
use Scribe\WonkaBundle\Component\DependencyInjection\Compiler\Attendant\AbstractCompilerAttendant;

/**
 * Class AbstractSwimRenderingHandler.
 */
abstract class AbstractSwimRenderingHandler extends AbstractCompilerAttendant implements SwimRenderingHandlerInterface
{
    /**
     * @var array
     */
    private $attributes = [];

    /**
     * @param null|string $string
     * @param array       $args
     *
     * @return string
     */
    abstract public function render($string, array $args = []);

    /**
     * @return string
     */
    abstract public function getCategory();

    /**
     * @param mixed ...$by
     *
     * @return bool
     */
    public function isSupported(...$by)
    {
        return true;
    }

    /**
     * @return string
     */
    public function getType($fqcn = false)
    {
        if (true === $fqcn) {
            return (string) get_class($this);
        }

        $className = ClassInfo::getClassNameByInstance($this);
        $className = substr($className, 4);
        $className = substr($className, 0, strlen($className) - 7);

        return $className;
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
     * @param SwimRenderingManagerInterface $manager
     *
     * @return $this
     */
    public function chainRendering(SwimRenderingManagerInterface $manager)
    {
        $manager->setWork(
            $this->render($manager->getWork())
        );

        $manager->addAttributes(
            $this->getAttributes()
        );

        return $this;
    }
}

/* EOF */

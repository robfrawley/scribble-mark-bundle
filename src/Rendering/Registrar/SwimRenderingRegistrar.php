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

use Symfony\Component\Stopwatch\Stopwatch;
use Scribe\Component\DependencyInjection\Aware\StopwatchActionsAwareTrait;
use Scribe\Component\DependencyInjection\Compiler\AbstractCompilerPassChain;
use Scribe\SwimBundle\Rendering\Handler\SwimRenderingHandlerInterface;

/**
 * Class SwimRenderingRegistrar.
 */
class SwimRenderingRegistrar extends AbstractCompilerPassChain implements SwimRenderingRegistrarInterface
{
    use StopwatchActionsAwareTrait;

    /**
     * @var array
     */
    protected $handlerCategorySet = [];

    /**
     * @var array
     */
    protected $handlerBlacklistSet = [];

    /**
     * @param Stopwatch|null $stopwatch
     * @param array          $handlerBlacklistSet
     */
    public function __construct(Stopwatch $stopwatch = null, array $handlerBlacklistSet = [])
    {
        parent::__construct(
            ['restrictions' => ['Scribe\SwimBundle\Rendering\Handler\SwimRenderingHandlerInterface']]
        );

        $this->setStopwatch($stopwatch);
        $this->setHandlerBlacklistSet($handlerBlacklistSet);

        $this->setAddHandlerCallable([$this, 'addSwimHandler']);
    }

    public function addSwimHandler(&$handlerCollection, SwimRenderingHandlerInterface $handler, $priority, $extra)
    {
        $extra = $this->getServiceExtraTagsSanitized($extra);

        if (true === $this->hasServiceExtraTag($extra, 'force_disabled', true)) {
            return;
        }

        if (false === $handler->isSupported($this->getHandlerBlacklistSet())) {
            return;
        }

        $handler->setStopwatch($this->getStopwatch());
        $handlerCollection[$priority] = $handler;

        if (true === $this->hasServiceExtraTag($extra, 'priority_end')) {
            $handlerCollection[(100 - $extra['priority_end'])] = $handler;
        }
    }

    /**
     * @param mixed $extra
     *
     * @return array
     */
    public function getServiceExtraTagsSanitized($extra)
    {
        return (array) ((null === $extra || false === is_array($extra)) ? [] : $extra);
    }

    /**
     * @param array      $extra
     * @param string     $key
     * @param null|mixed $value
     *
     * @return bool
     */
    public function hasServiceExtraTag(array $extra, $key, $value = null)
    {
        if (false === array_key_exists((string) $key, $extra)) {
            return false;
        }

        return (bool) (!(null !== $value && $extra[(string) $key] !== $value));
    }

    /**
     * @return bool[]
     */
    public function getHandlerCategorySet()
    {
        return $this->handlerCategorySet;
    }

    /**
     * @param bool[] $handlerCategorySet
     *
     * @return $this
     */
    public function setHandlerCategorySet(array $handlerCategorySet = [])
    {
        $this->handlerCategorySet = $handlerCategorySet;

        return $this;
    }

    /**
     * @param string $handlerCategory
     *
     * @return bool
     */
    public function hasHandlerCategory($handlerCategory)
    {
        return (bool) (true === array_key_exists((string) $handlerCategory, $this->handlerCategorySet));
    }

    /**
     * @param string $handlerCategory
     * @param bool   $state
     *
     * @return $this
     */
    public function addHandlerCategory($handlerCategory, $state = true)
    {
        $this->handlerCategorySet[(string) $handlerCategory] = (bool) $state;

        return $this;
    }

    /**
     * @param string $handlerCategory
     *
     * @return $this
     */
    public function removeHandlerCategory($handlerCategory)
    {
        if (true === $this->hasHandlerCategory($handlerCategory)) {
            unset($this->handlerCategorySet[$handlerCategory]);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getHandlerBlacklistSet()
    {
        return $this->handlerBlacklistSet;
    }

    /**
     * @param string[] $handlerBlacklistSet
     *
     * @return $this
     */
    public function setHandlerBlacklistSet(array $handlerBlacklistSet = [])
    {
        $this->handlerBlacklistSet = $handlerBlacklistSet;

        return $this;
    }

    /**
     * @param string $handler
     *
     * @return bool
     */
    public function hasHandlerBlacklist($handler)
    {
        return (bool) (true === in_array((string) $handler, $this->handlerBlacklistSet, true));
    }

    /**
     * @param string $handler
     *
     * @return $this
     */
    public function addHandlerBlacklist($handler)
    {
        if (false === $this->hasHandlerBlacklist((string) $handler)) {
            $this->handlerBlacklistSet[] = (string) $handler;
        }

        return $this;
    }

    /**
     * @param string $handler
     *
     * @return $this
     */
    public function removeHandlerBlacklist($handler)
    {
        if (true === $this->hasHandlerBlacklist((string) $handler) &&
            true !== ($handlerBlacklistKey = array_search($handler, $this->handlerBlacklistSet, true))) {
            unset($this->handlerBlacklistSet[(int) $handlerBlacklistKey]);
        }

        return $this;
    }
}

/* EOF */

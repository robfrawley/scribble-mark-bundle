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

/**
 * Class SwimRendererRegistrarInterface.
 */
interface SwimRenderingRegistrarInterface
{
    /**
     * @return bool[]
     */
    public function getHandlerCategorySet();

    /**
     * @param bool[] $handlerCategorySet
     *
     * @return $this
     */
    public function setHandlerCategorySet(array $handlerCategorySet = []);

    /**
     * @param string $handlerCategory
     *
     * @return bool
     */
    public function hasHandlerCategory($handlerCategory);

    /**
     * @param string $handlerCategory
     * @param bool   $state
     *
     * @return $this
     */
    public function addHandlerCategory($handlerCategory, $state = true);

    /**
     * @param string $handlerCategory
     *
     * @return $this
     */
    public function removeHandlerCategory($handlerCategory);

    /**
     * @return array
     */
    public function getHandlerBlacklistSet();

    /**
     * @param string[] $handlerBlacklistSet
     *
     * @return $this
     */
    public function setHandlerBlacklistSet(array $handlerBlacklistSet = []);

    /**
     * @param string $handler
     *
     * @return bool
     */
    public function hasHandlerBlacklist($handler);

    /**
     * @param string $handler
     *
     * @return $this
     */
    public function addHandlerBlacklist($handler);

    /**
     * @param string $handler
     *
     * @return $this
     */
    public function removeHandlerBlacklist($handler);
}

/* EOF */

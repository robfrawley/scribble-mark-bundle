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

use Scribe\CacheBundle\DependencyInjection\Aware\CacheChainAwareTrait;

/**
 * Class SwimRenderingManagerCached.
 */
class SwimRenderingManagerCached extends SwimRenderingManager
{
    use CacheChainAwareTrait;

    /**
     * @param string $string
     * @param string $name
     *
     * @return mixed
     */
    public function render($string, $name = null)
    {
        if (null === ($cachedContent = $this->getCacheChain()->get($string))) {
            parent::render($string, $name);

            $cachedContent = [
                'content' => $this->getDone(),
                'attributes' => (array) $this->getAttributes(),
            ];

            $this->getCacheChain()->set($cachedContent, $string);
        } else {
            $this->setOriginal(null);
            $this->setWork(null);
        }

        $this->setAttributes((array) $cachedContent['attributes']);
        $this->setDone($cachedContent['content']);

        return $this->getDone();
    }
}

/* EOF */

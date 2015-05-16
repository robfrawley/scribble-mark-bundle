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

use Scribe\CacheBundle\Cache\Handler\Chain\HandlerChainAwareTrait;

/**
 * Class SwimRenderingManagerCached.
 */
class SwimRenderingManagerCached extends SwimRenderingManager
{
    use HandlerChainAwareTrait;

    /**
     * @param string $string
     * @param string $name
     *
     * @return mixed
     */
    public function render($string, $name = null)
    {
        if (null === ($cachedContent = $this->getCacheHandlerChain()->get($string))) {
            parent::render($string, $name);

            $cachedContent = [
                'content' => $this->getDone(),
                'attributes' => (array) $this->getAttributes()
            ];

            $this->getCacheHandlerChain()->set($cachedContent, $string);
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

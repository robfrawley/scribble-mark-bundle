<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Component\Parser;

use Scribe\Component\DependencyInjection\Container\ContainerAwareTrait;
use Scribe\Utility\Observer\SubjectAbstract;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class SwimParser.
 */
class SwimParser extends SubjectAbstract implements SwimInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    public $STD_CONFIG = [
        'Exclude',
        'Block',
        'LinkWikipedia',
        'LinkExternal',
        'LinkInternal',
        'BootstrapColumn',
        'BootstrapTooltip',
        'ImageBlog',
        'Callout',
        'CharacterStyle',
        'ParagraphStyle',
        'Markdown',
        'BootstrapCollapse',
        'BootstrapWell',
        'MarkdownCleanup',
        'BootstrapTableLook',
        'BootstrapTableFeel',
        'ParagraphLead',
        'Exclude'
    ];

    /**
     * @var string
     */
    private $original = null;

    /**
     * @var string
     */
    private $work = null;

    /**
     * @var string
     */
    private $done = null;

    /**
     * @var array
     */
    private $attr = [];

    /**
     * @var bool
     */
    private $rendered = false;

    /**
     * @var array
     */
    private $parsers = [];

    /**
     * @var array
     */
    private $config = [];

    /**
     * @var UserlandCacheInterface
     */
    private $cache = null;

    /**
     * @var bool
     */
    private $cacheEnabled = true;

    /**
     * @param ContainerInterface $container
     * @param array              $config
     */
    public function __construct(ContainerInterface $container = null, array $config = null)
    {
        parent::__construct();

        $this->setContainer($container);
        $this->configure($config);
    }

    /**
     * @param  string $key
     * @return mixed
     */
    public function getAttr($key)
    {
        if (array_key_exists($key, $this->attr)) {
            return $this->attr[$key];
        }

        return null;
    }

    /**
     * @param  string $key
     * @param  mixed  $value
     * @return $this
     */
    public function setAttr($key, $value)
    {
        $this->attr[(string) $key] = $value;

        return $this;
    }

    /**
     * @param  string $key
     * @return boolean
     */
    public function hasAttr($key)
    {
        if (array_key_exists($key, $this->attr)) {
            return true;
        }

        return false;
    }

    /**
     * @param  null|string $string
     * @return $this
     */
    public function setOriginal($string = null)
    {
        $this->original = $string;
        $this->rendered = false;
        $this->setWork(null);
        $this->setDone(null);

        return $this;
    }

    /**
     * @return string
     */
    public function getOriginal()
    {
        return $this->original;
    }

    /**
     * @param  null|string $string
     * @return $this
     */
    public function setWork($string = null)
    {
        $this->work = $string;

        return $this;
    }

    /**
     * @param  boolean $new
     * @return string
     */
    public function getWork($new = false)
    {
        if ($this->work === null || $new === true) {
            $this->setWork($this->getOriginal());
        }

        return $this->work;
    }

    /**
     * @param null|string $string
     * @return $this
     */
    public function setDone($string = null)
    {
        $this->done = $string;

        return $this;
    }

    /**
     * @param  boolean $new
     * @return string
     */
    public function getDone($new = false)
    {
        if ($this->done === null || $new === true) {
            $this->setDone($this->getWork());
        }

        return $this->done;
    }

    /**
     * @param  array $config
     * @param  bool  $new
     * @return $this
     */
    public function configure(array $config = null, $new = false)
    {
        if ($config !== null) {
            $this->config = (array)$config;
        }

        if ($new === true) {
            $this->detachAll();
        }

        foreach ($this->config as $i => $v) {

            if (!array_key_exists($v, $this->parsers) || !$this->parsers[$v] instanceof SwimInterface) {
                $obj = __NAMESPACE__.'\Step\Swim'.$v.'Step';
                $this->parsers[$v] = new $obj($this->container);
            }

            $this->attach($this->parsers[$v]);
        }

        return $this;
    }

    /**
     * @param  null|string $string
     * @return string
     */
    public function render($string = null)
    {
        if ($string !== null) {
            $this->setOriginal($string);
            $this->rendered = false;
        }

        if ($this->rendered === false && $this->getCache() === false) {

            $this->notify();
            $this->setCache();
            $this->rendered = true;

        }

        return $this->getDone();
    }

    /**
     * set cached content
     */
    public function setCache()
    {
        if ($this->getCacheEnabled() === false || !$this->cache instanceof UserlandCacheInterface) {
            return;
        }

        $key = $this->getCacheKey();

        return $this
            ->cache
            ->set($key, $this->getDone())
        ;
    }

    /**
     * get cache content
     */
    public function getCache()
    {
        if ($this->getCacheEnabled() === false || !$this->cache instanceof UserlandCacheInterface) {
            return false;
        }

        $key = $this->getCacheKey();

        $cached = $this
            ->cache
            ->get($key, null)
        ;

        if ($cached === null) {
            return false;
        }

        $this->setDone($cached);
        return true;
    }
}

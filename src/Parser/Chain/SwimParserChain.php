<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Parser\Chain;

use Scribe\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Scribe\Utility\Observer\SubjectAbstract;
use Scribe\Component\DependencyInjection\Container\ContainerAwareTrait;
use Scribe\SwimBundle\Parser\Handler\SwimParserHandlerInterface;

/**
 * Class SwimParser.
 */
class SwimParserChain extends SubjectAbstract implements SwimParserChainInterface
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
            $this->config = (array) $config;
        }

        if ($new === true) {
            $this->detachAll();
        }

        foreach ($this->config as $handlerType) {
            $handler = $this->addHandlerToStack($handlerType);
            $this->attach($handler);
        }

        return $this;
    }

    /**
     * @param string $handlerType
     *
     * @throws RuntimeException
     *
     * @return \SplObserver
     */
    private function addHandlerToStack($handlerType)
    {
        if (true === array_key_exists($handlerType, $this->parsers) &&
            true === $this->parsers[$handlerType] instanceof SwimParserHandlerInterface) {
            return $this->parsers[$handlerType];
        }

        $className = sprintf(
            'Scribe\SwimBundle\Parser\Handler\Type\Swim%sHandlerType',
            $handlerType
        );

        if (false === class_exists($className)) {
            throw new RuntimeException(
                'Could not add Swim handler to parser chain as "%s" does not exist (called in "%s").',
                null, null, null, $className, __METHOD__
            );
        }

        $this->parsers[$handlerType] = new $className($this->getContainer());

        return $this->parsers[$handlerType];
    }

    /**
     * @param  null|string $string
     *
     * @return string
     */
    public function render($string = null)
    {
        if ($string !== null) {
            $this->setOriginal($string);
            $this->rendered = false;
        }

        if ($this->rendered === false) {
            $this->notify();
            $this->rendered = true;
        }

        return $this->getDone();
    }
}

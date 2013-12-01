<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\LearningBundle\Utility\Parser\Swim;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;
use Scribe\SharedBundle\Utility\Container\ContainerAwareTrait,
    Scribe\SharedBundle\Utility\Filters\String,
    Scribe\SharedBundle\Utility\Subject\SubjectAbstract,
    Scribe\LearningBundle\Utility\Parser\ParserInterface;

/**
 * Swim
 */
class Swim extends SubjectAbstract implements ParserInterface, ContainerAwareInterface
{
    use ContainerAwareTrait {
        ContainerAwareTrait::__construct as __traitConstruct;
    }

    /**
     * @var string
     */
    private $parsed;

    /**
     * @var string
     */
    private $original;

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
    private $config = [
        'Profiler',
        'ExcludeLevel',
        'BlockLevel',
        'NodeLink', 
        'WikipediaLink', 
        'ExternalLink', 
        'BootstrapCols',
        'BootstrapTooltip',
        'LearningImage', 
        'Queries',
        'Markdown',
        'BootstrapCollapse',
        'BootstrapWell',
        'BootstrapTables',
        'HtmlCleanup',
        'Toc',
        'TableSanity',
        'LeadParagraph',
        'ExcludeLevel',
        'Profiler',
    ];

    /**
     * @param ContainerInterface $container
     * @param array $config
     */
    public function __construct(ContainerInterface $container = null, array $config = null)
    {
        $this->__traitConstruct($container);
        $this->configure($config);
    }

    /**
     * @param array $config
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

            if (!array_key_exists($v, $this->parsers) || !$this->parsers[$v] instanceof ParserInterface) {
                $obj = __NAMESPACE__.'\SwimParser'.$v;
                $this->parsers[$v] = new $obj($this->container);
            }

            $this->attach($this->parsers[$v], true);
        }

        return $this;
    }

    /**
     * @param null $string
     * @return $this
     */
    public function setContent($string = null)
    {
        $this->string = $string;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->string;
    }

    /**
     * @param null $string
     * @return string
     */
    public function render($string = null)
    {
        if ($string !== null) {
            $this->setContent($string);
            $this->rendered = false;
        }
        if ($this->rendered === false) {
            $this->notify();
            $this->rendered = true;
        }

        return $this->getContent();
    }
}
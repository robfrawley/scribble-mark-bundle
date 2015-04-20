<?php

/*
 * This file is part of the Scribe Mantle Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Templating\Generator\Node\Rendering;

use Scribe\SwimBundle\Component\Parser\SwimParser;

/**
 * Class NodeRendererSwim.
 */
class NodeRendererSwim extends AbstractNodeRenderer
{
    /**
     * The supported slug (name) of this renderer.
     *
     * @var string
     */
    const SUPPORTED_NAME = 'swim';

    /**
     * @var array 
     */
    const SWIM_CONFIG = [
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
        'Toc',
        'Index',
        'Exclude',
    ];

    /**
     * @var SwimParser 
     */
    private $swim;

    /**
     * @var string
     */
    private $nodeParsed;

    /**
     * @var string
     */
    private $nodeToc;

    /**
     * @var string
     */
    private $nodeIndex;

    /**
     * @var string
     */
    private $nodeIndexLevels;

    public function __construct(SwimParser $swim)
    {
        $this->swim = $swim;
        $this->configureSwim();
    }

    /**
     * Gets the value of swim
     *
     * @return swim
     */
    public function getSwim()
    {
        return $this->swim;
    }

    /**
     * Sets the value of swim
     *
     * @param SwimParser $swim
     *
     * @return $this
     */
    public function setSwim(SwimParser $swim)
    {
        $this->swim = $swim;

        return $this;
    }

    /**
     * Sets the configuration for Swim
     *
     * @param SwimParser $swim
     *
     * @return $this
     */
    private function configureSwim()
    {
        $this
            ->getSwim
            ->configure(self::SWIM_CONFIG, true)
        ;

        return $this;
    }

    /**
     * Render a node item.
     *
     * @param string $string The content/template to be rendered
     * @param array  $args   Arguments to pass to the renderer
     *
     * @return string
     */
    public function render($string, array $args = [])
    {
        $rendered        = $this
            ->getSwim()
            ->render($string)
        ;
        $this->setNodeParsed($rendered);

        $nodeToc         = $this
            ->getSwim()
            ->getAttr('toc_html')
        ;
        $this->setNodeToc($nodeToc);

        $nodeIndex       = $this
            ->getSwim()
            ->getAttr('index_html')
        ;
        $this->setNodeIndex($nodeIndex);
        
        $nodeIndexLevels = $this
            ->getSwim()
            ->getAttr('index_levels')
        ;
        $this->setNodeIndexLevels($nodeIndexLevels);

        return $rendered;
    }

    /**
     * Returns the renderType name supported by this renderer implementation.
     *
     * @returns string
     */
    protected function getRendererName()
    {
        return self::SUPPORTED_NAME;
    }

    /**
     * Gets the value of nodeParsed
     *
     * @return string 
     */
    public function getNodeParsed()
    {
        return $this->nodeParsed;
    }

    /**
     * Sets the value of nodeParsed
     *
     * @param nodeParsed $nodeParsed description
     *
     * @return $this
     */
    public function setNodeParsed($nodeParsed)
    {
        $this->nodeParsed = $nodeParsed;

        return $this;
    }

    /**
     * Gets the value of nodeToc
     *
     * @return nodeToc
     */
    public function getNodeToc()
    {
        return $this->nodeToc;
    }

    /**
     * Sets the value of nodeToc
     *
     * @param nodeToc $nodeToc description
     *
     * @return $this
     */
    public function setNodeToc($nodeToc)
    {
        $this->nodeToc = $nodeToc;

        return $this;
    }

    /**
     * Gets the value of nodeIndex
     *
     * @return nodeIndex
     */
    public function getNodeIndex()
    {
        return $this->nodeIndex;
    }

    /**
     * Sets the value of nodeIndex
     *
     * @param nodeIndex $nodeIndex description
     *
     * @return $this
     */
    public function setNodeIndex($nodeIndex)
    {
        $this->nodeIndex = $nodeIndex;

        return $this;
    }

    /**
     * Gets the value of nodeIndexLevels
     *
     * @return nodeIndexLevels
     */
    public function getNodeIndexLevels()
    {
        return $this->nodeIndexLevels;
    }

    /**
     * Sets the value of nodeIndexLevels
     *
     * @param nodeIndexLevels $nodeIndexLevels description
     *
     * @return $this
     */
    public function setNodeIndexLevels($nodeIndexLevels)
    {
        $this->nodeIndexLevels = $nodeIndexLevels;

        return $this;
    }
}

/* EOF */

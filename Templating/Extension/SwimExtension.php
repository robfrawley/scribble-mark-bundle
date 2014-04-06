<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Templating\Extension;

use Scribe\SharedBundle\Templating\Extension\Part\SimpleExtensionTrait,
    Scribe\SharedBundle\Templating\Extension\Part\ContainerAwareExtensionTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Extension,
    Twig_SimpleFilter;

/**
 * SwimExtension
 */
class SwimExtension extends Twig_Extension
{
    use ContainerAwareExtensionTrait;

    /**
     * @param $container ContainerInterface
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->setContainer($container);
    }

    /**
     * @param  $content string
     * @return string
     */
    public function swimGeneral($content)
    {
        $config = [
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
            'BootstrapTable',
            'ParagraphLead',
            'Exclude',
        ];

        $swim = $this->container->get('scribe.parser.swim');
        $swim->configure($config, true);

        return $swim->render($content);
    }

    /**
     * @param  $content string
     * @return string
     */
    public function swimLearning($content)
    {
        $config = [
            'Exclude',
            'Block',
            'LinkWikipedia', 
            'LinkExternal',
            'LinkInternal',
            'BootstrapColumn',
            'BootstrapTooltip',
            'Callout',
            'CharacterStyle',
            'ParagraphStyle', 
            'Markdown',
            'BootstrapCollapse',
            'BootstrapWell',
            'MarkdownCleanup',
            'BootstrapTable',
            'ParagraphLead',
            'Exclude',
        ];

        $swim = $this->container->get('scribe.parser.swim');
        $swim->configure($config, true);
        
        return $swim->render($content);
    }

    /**
     * @param  $content string
     * @return string
     */
    public function swimBlog($content)
    {
        $config = [
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
            'BootstrapTable',
            'ParagraphLead',
            'Exclude',
        ];

        $swim = $this->container->get('scribe.parser.swim');
        $swim->configure($config, true);

        return $swim->render($content);
    }

    /**
     * @param  $content string
     * @return string
     */
    public function swimBook($content)
    {
        $config = [
            'Exclude',
            'Block',
            'LinkWikipedia', 
            'LinkExternal',
            'LinkInternal',
            'BootstrapColumn',
            'BootstrapTooltip',
            'ImageBook', 
            'Callout',
            'CharacterStyle', 
            'ParagraphStyle',
            'Markdown',
            'BootstrapCollapse',
            'BootstrapWell',
            'MarkdownCleanup',
            'BootstrapTable',
            'ParagraphLead',
            'Exclude',
        ];

        $swim = $this->container->get('scribe.parser.swim');
        $swim->configure($config, true);

        return $swim->render($content);
    }

    /**
     * @return array
     */
    public function getFilters()
    {
        return [
            new Twig_SimpleFilter('swim',         [$this, 'swimGeneral'],  ['is_safe' => ['html']]),
            new Twig_SimpleFilter('swimgeneral',  [$this, 'swimGeneral'],  ['is_safe' => ['html']]),
            new Twig_SimpleFilter('swimlearning', [$this, 'swimLearning'], ['is_safe' => ['html']]),
            new Twig_SimpleFilter('swimblog',     [$this, 'swimBlog'],     ['is_safe' => ['html']]),
            new Twig_SimpleFilter('swimbook',     [$this, 'swimBook'],     ['is_safe' => ['html']]),
        ];
    }

    /**
     * @return string
     */
    public function getName()
    {
        return __CLASS__;
    }
}
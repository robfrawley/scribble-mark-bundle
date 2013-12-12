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
     * @param $content string
     * @return mixed
     */
    public function swim($content)
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

    public function swimblog($content)
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

    public function swimbook($content)
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
            new Twig_SimpleFilter('swim', [$this, 'swim'], ['is_safe' => ['html']]),
            new Twig_SimpleFilter('swimblog', [$this, 'swimblog'], ['is_safe' => ['html']]),
            new Twig_SimpleFilter('swimbook', [$this, 'swimbook'], ['is_safe' => ['html']]),
        ];
    }

    public function getName()
    {
        return __CLASS__;
    }
}
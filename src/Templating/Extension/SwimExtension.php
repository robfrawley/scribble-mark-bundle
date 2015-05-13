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

use Scribe\MantleBundle\Templating\Extension\Part\SimpleExtensionTrait,
    Scribe\MantleBundle\Templating\Extension\Part\ContainerAwareExtensionTrait;
use Scribe\MantleBundle\Templating\Twig\AbstractTwigExtension;
use Scribe\SwimBundle\Component\Parser\SwimParserChain;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Twig_Extension,
    Twig_SimpleFilter;

/**
 * SwimExtension
 */
class SwimExtension extends AbstractTwigExtension
{
    /**
     * @var SwimParser
     */
    private $swimParser;

    /**
     * @var array
     */
    private static $stdConfig = [
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
        'Exclude',
    ];

    /**
     * @param SwimParser $swimParser
     */
    public function __construct(SwimParserChain $swimParser)
    {
        parent::__construct();

        $this->swimParser = $swimParser;

        $this->enableOptionHtmlSafe();

        $this->addFilter('swim', [$this, 'swimGeneral']);
        $this->addFilter('swimgeneral', [$this, 'swimGeneral']);
        $this->addFilter('swimlearning', [$this, 'swimLearning']);
        $this->addFilter('swimblog', [$this, 'swimBlog']);
        $this->addFilter('swimbook', [$this, 'swimBook']);
        $this->addFilter('swimdocs', [$this, 'swimDocs']);
    }

    /**
     * @param  $content string
     *
     * @return string
     */
    public function swimGeneral($content)
    {
        $this->swimParser->configure(self::$stdConfig, true);

        return $this->swimParser->render($content);
    }

    /**
     * @param  $content string
     *
     * @return string
     */
    public function swimDocs($content)
    {
        $this->swimParser->configure(self::$stdConfig, true);

        return $this->swimParser->render($content);
    }

    /**
     * @param  $content string
     *
     * @return string
     */
    public function swimLearning($content)
    {
        $this->swimParser->configure(self::$stdConfig, true);

        return $this->swimParser->render($content);
    }

    /**
     * @param  $content string
     *
     * @return string
     */
    public function swimBlog($content)
    {
        $this->swimParser->configure(self::$stdConfig, true);

        return $this->swimParser->render($content);
    }

    /**
     * @param  $content string
     *
     * @return string
     */
    public function swimBook($content)
    {
        $this->swimParser->configure(self::$stdConfig, true);

        return $this->swimParser->render($content);
    }
}

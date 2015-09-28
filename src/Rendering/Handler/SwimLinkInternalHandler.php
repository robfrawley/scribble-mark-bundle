<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Rendering\Handler;

use InvalidArgumentException;
use Symfony\Component\Routing\RouterInterface;

/**
 * SwimLinkInternalHandler.
 */
class SwimLinkInternalHandler extends AbstractSwimRenderingHandler
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return self::CATEGORY_LINK_INTERNAL_ROUTING;
    }

    /**
     * @param string $string
     * @param array  $args
     *
     * @return string
     */
    public function render($string, array $args = [])
    {
        $work = $this->renderLinks($string);
        $work = $this->renderPaths($work);

        return $work;
    }

    public function renderLinks($work)
    {
        $pattern = '#{~a-in:([^ ]*?)( (.*?))?}#i';
        $matches = [];
        @preg_match_all($pattern, $work, $matches);

        if (count($matches[0]) > 0) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original = $matches[0][$i];
                $url = $matches[1][$i];
                $title = empty($matches[3][$i]) ? $url : $matches[3][$i];
                $replace = '<a href="'.$url.'">'.$title.'</a>';
                $work = str_replace($original, $replace, $work);
            }
        }

        return $work;
    }

    public function renderPaths($work)
    {
        $pattern = '#{~path:([^ ]*?)( (.*?))?( ?{(.*?)})?}#i';
        $matches = [];
        @preg_match_all($pattern, $work, $matches);

        if (count($matches[0]) > 0) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original = $matches[0][$i];
                $path = $matches[1][$i];
                $title = empty($matches[3][$i]) ? $path : $matches[3][$i];
                $pathArgs = empty($matches[5][$i]) ? []   : @json_decode('{'.$matches[5][$i].'}', true);

                try {
                    $url = $this->router->generate($path, $pathArgs);
                } catch (InvalidArgumentException $e) {
                    $url = '#';
                }

                $replace = '<a href="'.$url.'">'.$title.'</a>';
                $work = str_replace($original, $replace, $work);
            }
        }

        return $work;
    }
}

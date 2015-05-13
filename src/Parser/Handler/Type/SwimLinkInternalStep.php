<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Component\Parser\Step;

use Scribe\SwimBundle\Parser\Handler\AbstractSwimParserHandlerType;
use InvalidArgumentException;

/**
 * SwimLinkInternalStep
 * Handles all internal (same domain) links and symfony router paths
 */
class SwimLinkInternalStep extends AbstractSwimParserHandlerType
{
    /**
     * @param  null $work
     * @return string
     */
    public function render($work = null)
    {

        $work = $this->renderLinks($work);
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
                $url      = $matches[1][$i];
                $title    = empty($matches[3][$i]) ? $url : $matches[3][$i];
                $replace  = '<a href="'.$url.'">'.$title.'</a>';
                $work     = str_replace($original, $replace, $work);
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

            $router = $this
                ->getContainer()
                ->get('router')
            ;

            for ($i = 0; $i < count($matches[0]); $i++) {

                $original = $matches[0][$i];
                $path     = $matches[1][$i];
                $title    = empty($matches[3][$i]) ? $path : $matches[3][$i];
                $pathArgs = empty($matches[5][$i]) ? []   : @json_decode('{'.$matches[5][$i].'}', true);

                try {
                    $url = $router->generate($path, $pathArgs);
                }
                catch(InvalidArgumentException $e) {
                    $url = '#';
                }

                $replace  = '<a href="'.$url.'">'.$title.'</a>';
                $work     = str_replace($original, $replace, $work);
            }
        }

        return $work;
    }
}

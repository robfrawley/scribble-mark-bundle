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

/**
 * Class SwimLinkExternalHandler.
 */
class SwimLinkExternalHandler extends AbstractSwimRenderingHandler
{
    /**
     * @return string
     */
    public function getCategory()
    {
        return self::CATEGORY_LINK_DECORATING;
    }

    /**
     * @param string $string
     * @param array  $args
     *
     * @return string
     */
    public function render($string, array $args = [])
    {
        $this->stopwatchStart($this->getType(), 'Swim');

        @preg_match_all('#{~a:([^ ]*?)( (.*?))?}#i', $string, $nodeAMatches);
        if (0 < count($nodeAMatches[0])) {
            for ($i = 0; $i < count($nodeAMatches[0]); $i++) {
                $original = $nodeAMatches[0][$i];
                $url = $nodeAMatches[1][$i];
                if (substr($url, 0, 4) !== 'http') {
                    $url = 'http://'.$url;
                }
                $title = empty($nodeAMatches[3][$i]) ? $url : $nodeAMatches[3][$i];
                $replace = '<i class="fa fa-link a-external-icon"></i> <a class="a-external" href="'.$url.'">'.$title.'</a>';

                $string = str_replace($original, $replace, $string);
            }
        }

        @preg_match_all('#{~a-popup:([^ ]*?)( (.*?))?}#i', $string, $nodeAMatches);
        if (0 < count($nodeAMatches[0])) {
            for ($i = 0; $i < count($nodeAMatches[0]); $i++) {
                $original = $nodeAMatches[0][$i];
                $url = $nodeAMatches[1][$i];
                if (substr($url, 0, 4) !== 'http') {
                    $url = 'http://'.$url;
                }
                $title = empty($nodeAMatches[3][$i]) ? $url : $nodeAMatches[3][$i];
                $replace = '<span data-popup="true"><i class="fa fa-link a-external-icon"></i> <a class="a-external" href="'.$url.'">'.$title.'</a></span>';

                $string = str_replace($original, $replace, $string);
            }
        }

        $nodeAMatches = [];
        @preg_match_all('#{~mail:([^ ]*?)( (.*?))?}#i', $string, $nodeAMatches);
        if (0 < count($nodeAMatches[0])) {
            for ($i = 0; $i < count($nodeAMatches[0]); $i++) {
                $original = $nodeAMatches[0][$i];
                $url = $nodeAMatches[1][$i];
                $title = empty($nodeAMatches[3][$i]) ? $url : $nodeAMatches[3][$i];
                $replace = '<i class="fa fa-envelope a-external-icon"></i> <a class="a-external" href="mailto:'.$url.'">'.$title.'</a>';

                $string = str_replace($original, $replace, $string);
            }
        }

        $this->stopwatchStop($this->getType());

        return $string;
    }
}

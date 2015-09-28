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
 * Class SwimLinkWikipediaHandler.
 */
class SwimLinkWikipediaHandler extends AbstractSwimRenderingHandler
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
        @preg_match_all('#{~wiki:([^ ]*?)( (.*?))?}#i', $string, $nodeWikiMatches);
        if (0 < count($nodeWikiMatches[0])) {
            for ($i = 0; $i < count($nodeWikiMatches[0]); $i++) {
                $original = $nodeWikiMatches[0][$i];
                $key = $nodeWikiMatches[1][$i];
                $title = empty($nodeWikiMatches[3][$i]) ? $key : $nodeWikiMatches[3][$i];
                $replace = '<i class="icon-external-link a-external-icon"> </i><a class="a-external a-wikipedia" href="http://en.wikipedia.org/wiki/'.$key.'">'.$title.'</a>';

                $string = str_replace($original, $replace, $string);
            }
        }

        return $string;
    }
}

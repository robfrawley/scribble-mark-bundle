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

/**
 * Class SwimImageBookStep
 */
class SwimImageBookStep extends AbstractSwimParserHandlerType
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        $matches = [];
        @preg_match_all('#{~image:([^\s]*?)(\s(.*?))?}#i', $string, $matches);

        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $original    = $matches[0][$i];
                $image_src   = $matches[1][$i];
                $image_title = $matches[2][$i];
                $replace     =
                    '<div class="text-center">'.
                    '<img src="/static/images/book/'.$image_src.'" alt="Image: '.$image_title.'">'.
                    '<p><small class="text-muted">'.$image_title.'</small></p>'.
                    '</div>'
                ;
                $string = str_replace($original, $replace, $string);
            }
        }

        return $string;
    }
}

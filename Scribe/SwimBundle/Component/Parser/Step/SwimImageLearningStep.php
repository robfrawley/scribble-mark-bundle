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

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Scribe\SwimBundle\Component\Parser\SwimInterface,
    Scribe\SwimBundle\Component\Parser\SwimAbstractStep;

/**
 * Class SwimParserLearningImage
 */
class SwimImageLearningStep extends SwimAbstractStep implements SwimInterface, ContainerAwareInterface
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
                $thumb_src   = pathinfo($image_src, PATHINFO_DIRNAME) . 
                               '/' . 
                               pathinfo($image_src, PATHINFO_FILENAME) . 
                               't.' . 
                               pathinfo($image_src, PATHINFO_EXTENSION)
                ;
                $image_title = empty($matches[2][$i]) ? 
                    $image_src : $matches[2][$i]
                ;
                $series_tag  = substr(pathinfo($image_src, PATHINFO_FILENAME), 0, -3);
                $replace = '<a href="/images/learning/'.$image_src.'" data-lightbox="lightroom_'.$series_tag.'" title="'.$image_title.'">' .
                           '<span class="lightbox-img-container" style="background-image:url(/images/learning/'.$thumb_src.')"></span>'.
                           '<small class="lightbox-desc-container">'.$image_title.'</small>'.
                           '</a>'
                ;
                $string = str_replace($original, $replace, $string);
            }
        }

        return $string;
    }
}
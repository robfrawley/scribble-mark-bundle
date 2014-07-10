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
use \Sundown;

/**
 * Class SwimParagraphStyleStep
 */
class SwimParagraphStyleStep extends SwimAbstractStep implements SwimInterface, ContainerAwareInterface
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        $markdown = $this->getContainer()->get('kwattro_markdown');

        @preg_match_all('#<\s([^\|]*?)\|(.*)#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $pullquote   = $matches[1][$i];
                $para = $matches[2][$i];
                $replace = '<p class="has-pullquote" data-pullquote="'.$pullquote.'">'.$para.'</p>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        return $string;
    }
}
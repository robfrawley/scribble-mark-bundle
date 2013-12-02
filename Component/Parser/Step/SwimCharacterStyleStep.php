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
 * Class SwimParserCharacterStyles
 */
class SwimCharacterStyleStep extends SwimAbstractStep implements SwimInterface, ContainerAwareInterface
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        $renderer = $this
            ->getContainer()
            ->get('varspool_markdown')
        ;

        @preg_match_all('#{~sm:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<small class="text-muted">'.$renderer->render($matches[1][$i]).'</small>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        return $string;
    }
}
<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\LearningBundle\Utility\Parser\Swim;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;
use Scribe\SharedBundle\Utility\Filters\String,
    Scribe\LearningBundle\Utility\Parser\ParserInterface;

/**
 * Class SwimParserBootstrapWell
 */
class SwimParserBootstrapWell extends SwimParserObserver implements ParserInterface, ContainerAwareInterface
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        $string = str_ireplace('{~well:start}', '<div class="well">', $string);
        $string = str_ireplace('{~well:end}',   '</div>',             $string);

        return $string;
    }
}
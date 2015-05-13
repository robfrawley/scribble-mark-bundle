<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Parser;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;

/**
 * Class SwimInterface.
 */
interface SwimParserInterface extends ContainerAwareInterface
{
    /**
     * @param null $string
     *
     * @return mixed
     */
    public function render($string = null);
}

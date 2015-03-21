<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Component\Parser;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;
use Scribe\Component\DependencyInjection\ContainerAwareTrait;
use SplSubject,
    SplObserver;

/**
 * StepAbstract
 * abstract class from which all parser steps must inherit from
 */
class SwimAbstractStep implements ContainerAwareInterface, SplObserver
{
    use ContainerAwareTrait;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->setContainer($container);
    }

    /**
     * @param  SplSubject $subject
     * @return $this
     */
    public function update(SplSubject $subject)
    {
        $subject->setWork(
            $this->render($subject->getWork())
        );

        return $this;
    }
}
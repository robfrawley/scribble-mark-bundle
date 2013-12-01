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
use Scribe\SharedBundle\Utility\Container\ContainerAwareTrait,
    Scribe\SharedBundle\Utility\Observer\ObserverAbstract,
    Scribe\SharedBundle\Utility\Filters\String;
use SplSubject;

/**
 * Class SwimParserObserver
 */
class SwimParserObserver extends ObserverAbstract implements ContainerAwareInterface
{
    use ContainerAwareTrait;

    /**
     * @param SplSubject $subject
     * @return $this
     */
    public function update(SplSubject $subject)
    {
        $content = $subject->getContent();
        $content = $this->render($content);
        $subject->setContent($content);

        return $this;
    }
}
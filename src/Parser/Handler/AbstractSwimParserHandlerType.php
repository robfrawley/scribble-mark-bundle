<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Parser\Handler;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Scribe\SwimBundle\Parser\Chain\SwimParserChain;
use Scribe\SwimBundle\Parser\Handler\SwimParserHandlerInterface;

/**
 * Class AbstractSwimParserHandlerType.
 */
abstract class AbstractSwimParserHandlerType extends AbstractSpl implements ContainerAwareInterface, SwimParserHandlerInterface
{
    use ContainerAwareTrait;

    /**
     * @param null $string
     *
     * @return mixed
     */
    abstract public function render($string = null);

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container = null)
    {
        $this->setContainer($container);
    }

    /**
     * @param SwimParserChain $subject
     *
     * @return $this
     */
    public function update(SwimParserChain $subject)
    {
        $subject->setWork(
            $this->render($subject->getWork())
        );

        return $this;
    }
}

<?php

/*
 * This file is part of the Scribe Swim Bundle.
 *
 * (c) Scribe Inc. <source@scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\DependencyInjection\Compiler\Registrar;

use Scribe\WonkaBundle\Component\DependencyInjection\Compiler\Attendant\CompilerAttendantInterface;
use Scribe\WonkaBundle\Component\DependencyInjection\Compiler\Registrar\AbstractCompilerRegistrar;

/**
 * Class RendererCompilerRegistrar.
 */
class RendererCompilerRegistrar extends AbstractCompilerRegistrar
{
    /**
     * Construct object with default parameters. Any number of parameters may be passed so long as they are each a
     * single-element associative array of the form [propertyName=>propertyValue]. If passed, these additional
     * parameters will overwrite the default instance properties and, as such, runtime handling of this registrar.
     *
     * @param array[] ...$parameters
     */
    public function __construct(...$parameters)
    {
        parent::__construct(
            ['interfaceCollection' => ['Scribe\SwimBundle\Rendering\Handler\SwimRenderingHandlerInterface']]
        );
    }

    /**
     * @param CompilerAttendantInterface $attendant
     * @param null|int                   $priority
     * @param array                      $extra
     *
     * @return $this
     */
    public function addAttendant(CompilerAttendantInterface $attendant, $priority = null, $extra = [])
    {
        if (!$this->isValidAttendant($attendant)) {
            return $this;
        }

        $extra = $this->getServiceExtraTagsSanitized($extra);

        if (true === $this->hasServiceExtraTag($extra, 'force_disabled', true)) {
            return $this;
        }

        if (true === $this->hasServiceExtraTag($extra, 'priority_end')) {
            $this->attendantCollection[(9999 - $extra['priority_end'])] = $attendant;
        }

        return parent::addAttendant($attendant, $priority, $extra);
    }

    /**
     * @param mixed $extra
     *
     * @return array
     */
    protected function getServiceExtraTagsSanitized($extra)
    {
        return (array) ((null === $extra || false === is_array($extra)) ? [] : $extra);
    }

    /**
     * @param array      $extra
     * @param string     $key
     * @param null|mixed $value
     *
     * @return bool
     */
    protected function hasServiceExtraTag(array $extra, $key, $value = null)
    {
        if (false === array_key_exists((string) $key, $extra)) {
            return false;
        }

        return (bool) (!(null !== $value && $extra[(string) $key] !== $value));
    }
}

/* EOF */

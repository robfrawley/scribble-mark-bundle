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
    Scribe\SwimBundle\Component\Parser\SwimAbstractStep,
    Scribe\SecurityBundle\Entity\Org,
    Scribe\SecurityBundle\Entity\User;

/**
 * SwimParserBlockLevel
 */
class SwimExcludeStep extends SwimAbstractStep implements SwimInterface, ContainerAwareInterface
{
    /**
     * @var boolean
     */
    protected $firstPass = true;

    /**
     * @var array
     */
    protected $excludes = [];

    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        if ($this->firstPass === true) {
            $this->firstPass = false;
            return $this->renderFirstPass($string);
        } else {
            return $this->renderSecondPass($string);
        }
    }

    /**
     * @param string $string
     * @return string
     */
    public function renderFirstPass($string = null)
    {
        $matches = [];
        @preg_match_all('#{~ex:start}((.*?\n?)*?){~ex:end}#i', $string, $matches);

        for ($i = 0; $i < count($matches[0]); $i++) {
            $original = $matches[0][$i];
            $content  = $matches[1][$i];
            $anchor   = md5($content.$i);
            $replace  = '{~ex:anchor:'.$anchor.'}';

            $string = str_replace($original, $replace, $string);

            $this->excludes[$anchor] = $content;
        }

        return $string;
    }

    /**
     * @param string $string
     * @return string
     */
    public function renderSecondPass($string = null)
    {
        $matches = [];
        $pattern = '#{~ex:anchor:(.*?)}#i';
        @preg_match_all($pattern, $string, $matches);

        for ($i = 0; $i < count($matches[0]); $i++) {
            $original = $matches[0][$i];
            $md5      = $matches[1][$i];
            $replace  = $this->excludes[$md5];

            $string = str_replace($original, $replace, $string);
        }
        
        return $string;
    }
}
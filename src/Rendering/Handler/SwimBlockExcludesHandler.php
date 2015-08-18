<?php

/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Rendering\Handler;

/**
 * SwimBlockExcludesHandler.
 */
class SwimBlockExcludesHandler extends AbstractSwimRenderingHandler
{
    /**
     * @var int
     */
    private $handlerPassCount = 0;

    /**
     * @var array
     */
    private $blockExcludes = [];

    /**
     * @return string
     */
    public function getCategory()
    {
        return self::CATEGORY_BLOCK_EXCLUDES;
    }

    /**
     * @param string $string
     * @param array  $args
     *
     * @return string
     */
    public function render($string, array $args = [])
    {
        $this->stopwatchStart($this->getType(), 'Swim');

        $this->handlerPassCount++;

        if ($this->handlerPassCount % 2 !== 0) {
            $this->excludedBlocksRemove($string);
        } else {
            $this->excludedBlocksAdd($string);
        }

        $this->stopwatchStop($this->getType());

        return $string;
    }

    /**
     * @param string $string
     */
    public function excludedBlocksRemove(&$string)
    {
        if ((false === preg_match_all('#{~verbatim}((.*?\n?)*?){~verbatim:end}#i', $string, $matches)) &&
            (false === is_array($matches) || 2 !== count($matches) || 0 === count($matches[0]))) {
            return;
        }

        $matchesCount = count($matches[0]);
        $matchesOriginalStr = $matches[0];
        $matchesExcludedStr = $matches[1];

        for ($i = 0; $i < $matchesCount; $i++) {
            $temporaryHash = sha1($matchesExcludedStr.$i);
            $temporaryAnchor = '{~ex:anchor:'.$temporaryHash.'}';

            $string = str_replace($matchesOriginalStr[$i], $temporaryAnchor, $string);

            $this->blockExcludes[$temporaryAnchor] = $matchesOriginalStr[$i];
        }
    }

    /**
     * @param string $string
     */
    public function excludedBlocksAdd(&$string)
    {
        if ((false === preg_match_all('#{~ex:anchor:(.*?)}#i', $string, $matches)) &&
            (false === is_array($matches) || 2 !== count($matches) || 0 === count($matches[0]))) {
            return;
        }

        $matchesCount = count($matches[0]);
        $matchesAnchor = $matches[0];
        $matchesHash = $matches[1];

        for ($i = 0; $i < $matchesCount; $i++) {
            $string = str_replace($matchesAnchor[$i], $this->blockExcludes[$matchesHash[$i]], $string);
        }
    }
}

/* EOF */

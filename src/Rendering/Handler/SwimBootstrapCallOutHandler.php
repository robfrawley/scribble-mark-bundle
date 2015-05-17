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
 * Class SwimParserQueries
 */
class SwimBootstrapCallOutHandler extends AbstractSwimRenderingHandler
{
    /**
     * @var \ParsedownExtra
     */
    private $parsedown;

    /**
     * Construct handler by creating parsedown instance.
     */
    public function __construct()
    {
        $this->parsedown = new \ParsedownExtra();
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return self::CATEGORY_BOOTSTRAP_COMPONENTS;
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

        $this->renderCallOutBlocks($string);

        $this->stopwatchStop($this->getType());

        return $string;
    }

    private function renderCallOutBlocks(&$string)
    {
        $matched = [];
        @preg_match_all('#{~\?:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-warning callout-no-header">'.$this->parsedown->text($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\!:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-danger callout-no-header">'.$this->parsedown->text($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\-:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-info callout-no-header">'.$this->parsedown->text($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\+:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-success callout-no-header">'.$this->parsedown->text($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\?\?:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-warning"><p class="callout-header">Note</p>'.$this->parsedown->text($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\!!:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-danger"><p class="callout-header">Key Point</p>'.$this->parsedown->text($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\-\-:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-info"><p class="callout-header">Tip</p>'.$this->parsedown->text($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $matched = [];
        @preg_match_all('#{~\+\+:(.*)}#i', $string, $matches);
        if (0 < count($matches[0])) {
            for ($i=0; $i<count($matches[0]); $i++) {
                $replace = '<div class="callout callout-success"><p class="callout-header">Success</p>'.$this->parsedown->text($matches[1][$i]).'</div>';
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }
    }
}

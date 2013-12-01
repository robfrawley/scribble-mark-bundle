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
 * Class SwimParserBootstrapTables
 */
class SwimParserBootstrapTables extends SwimParserObserver implements ParserInterface, ContainerAwareInterface
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        //$replace = '<table class="table table-condensed table-striped">';
        $pattern = '#<thead>.*?\n?.*?<tr>.*?\n?(.*?<td>.*?<\\/td>.*?\n?)*.*?<\\/tr>.*?\n?.*?<\\/thead>#i';
        $matches = [];
        @preg_match_all($pattern, $string, $matches);

        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $replace = str_ireplace('<td>',  '<th>',  $matches[0][$i]);
                $replace = str_ireplace('</td>', '</th>', $replace);
                $string  = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        $replace = '<table class="table table-condensed table-striped">';
        $pattern = '#<table.*?>#i';
        $matches = [];
        @preg_match_all($pattern, $string, $matches);

        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $string = str_ireplace($matches[0][$i], $replace, $string);
            }
        }

        return $string;
    }
}
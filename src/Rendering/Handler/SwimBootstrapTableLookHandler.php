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
 * Class SwimBootstrapTableLookStep
 */
class SwimBootstrapTableLookHandler extends AbstractSwimRenderingHandler
{
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

        list($config, $search) = $this->getConfig($string);

        if ($config === null || $search === null) {
            $this->stopwatchStop($this->getType());
            return $string;
        }

        $this->removeConfigFromContent($string, $search);
        $this->handleTableLook($string, $config);

        $this->stopwatchStop($this->getType());

        return $string;
    }

    /**
     * remove the config declaration from the file contents
     *
     * @param  string $content passed by reference
     * @param  string $search
     */
    private function removeConfigFromContent(&$content, $search)
    {
        $content = str_replace('<p>'.$search.'</p>', '', $content);
        $content = str_replace($search,              '', $content);
    }

    /**
     * check for and get the configuration defined in the content
     *
     * @param  string|null $content
     * @return array
     */
    private function getConfig($content = null)
    {
        $pattern = '#{~table:sanity:class:(.*?)}#i';
        $matches = [];
        @preg_match_all($pattern, $content, $matches);

        if (count($matches[0]) < 1) {
            return [null, null];
        }

        $config = array_pop($matches[1]);
        $search = array_pop($matches[0]);

        return [
            $config,
            $search,
        ];
    }

    private function handleTableLook(&$content, $config)
    {
        $pattern = '#<thead>.*?\n?.*?<tr>.*?\n?(.*?<td>.*?<\\/td>.*?\n?)*.*?<\\/tr>.*?\n?.*?<\\/thead>#i';
        $matches = [];
        @preg_match_all($pattern, $content, $matches);

        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $replace = str_ireplace('<td>',  '<th>',  $matches[0][$i]);
                $replace = str_ireplace('</td>', '</th>', $replace);
                $content = str_ireplace($matches[0][$i], $replace, $content);
            }
        }

        $replace = '<table class="'.implode(' ', explode(',', $config)).'">';
        $pattern = '#<table.*?>#i';
        $matches = [];
        @preg_match_all($pattern, $content, $matches);

        if (0 < count($matches[0])) {
            for ($i = 0; $i < count($matches[0]); $i++) {
                $content = str_ireplace($matches[0][$i], $replace, $content);
            }
        }
    }
}

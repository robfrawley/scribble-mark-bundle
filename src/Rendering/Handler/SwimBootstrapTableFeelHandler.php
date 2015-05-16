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
 * Class SwimBootstrapTableFeelHandler
 */
class SwimBootstrapTableFeelHandler extends AbstractSwimRenderingHandler
{
    /**
     * render this swim step
     *
     * @param  string|null $string
     * @return mixed|null
     */
    public function render($string = null, array $args = [])
    {
        list($config_cols, $config_size, $search) = $this->getConfig($string);

        if ($config_cols === null || $config_size === null || $search === null) {
            return $string;
        }

        $this->removeConfigFromContent($string, $search);
        $this->handleTableFeel($string, $config_cols, $config_size);

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
        $content = str_replace($search, '', str_replace('<p>'.$search.'</p>', '', $content));
    }

    /**
     * check for and get the configuration defined in the content
     *
     * @param  string|null $content
     * @return array
     */
    private function getConfig($content = null)
    {
        $pattern = '#{~table:sanity:sizes:([0-9]*?):([0-9,]*)}#i';
        $matches = [];
        @preg_match_all($pattern, $content, $matches);

        if (count($matches[0]) < 1) { return [null, null, null]; }

        $config_cols = array_pop($matches[1]);
        $config_size = array_pop($matches[2]);
        $search      = array_pop($matches[0]);

        return [
            $config_cols,
            $config_size,
            $search,
        ];
    }

    /**
     * handle setting column widths for the tables
     *
     * @param  string $content     passed by reference
     * @param  int    $config_cols
     * @param  string $config_size
     */
    private function handleTableFeel(&$content, $config_cols, $config_size)
    {
        $config_sizes = explode(',', $config_size);

        if ($config_cols != count($config_sizes)) {
            return;
        }

        $rowPattern = '';
        foreach (range(1, $config_cols) as $i) {
            $rowPattern .= '(.*?<th>.*?<\\/th>.*?\n?)';
        }

        $pattern = '#<thead>.*?\n?.*?<tr>.*?\n?'.$rowPattern.'.*?<\\/tr>.*?\n?.*?<\\/thead>#i';
        $matches = [];
        @preg_match_all($pattern, $content, $matches);

        $strSearch = [];
        $strReplace = [];

        for ($i = 0; $i < count($matches[0]); $i++) {
            foreach (range(1, $config_cols) as $j) {
                if (!in_array($matches[$j][$i], $strSearch)) {
                    $strSearch[] = $matches[$j][$i];
                    $strReplace[] = str_ireplace('<th>', '<th width="'.$config_sizes[$j-1].'%">', $matches[$j][$i]);
                }
            }
        }

        for ($i = 0; $i < count($strSearch); $i++) {
            $content = str_ireplace($strSearch[$i], $strReplace[$i], $content);
        }
    }
}

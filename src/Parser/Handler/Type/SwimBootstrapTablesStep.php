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

use Scribe\SwimBundle\Parser\Handler\AbstractSwimParserHandlerType;

/**
 * Class SwimParserTableSanity
 */
class SwimBootstrapTablesStep extends AbstractSwimParserHandlerType
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        $pattern = '#{~table:sanity:([0-9]*?):([0-9,]*)}#i';
        $matches = [];
        @preg_match_all($pattern, $string, $matches);

        for ($i = 0; $i < count($matches[0]); $i++) {
            if (empty($matches[1][$i]) || empty($matches[2][$i])) {
                continue;
            }

            $rowCount = (int)$matches[1][$i];
            $rowSizes = explode(',', $matches[2][$i]);

            if (count($rowSizes) !== $rowCount) {
                continue;
            }

            $string = $this->handleTableSanity($string, $rowCount, $rowSizes);
            $string = str_ireplace('<p>'.$matches[0][$i].'</p>', '', $string);
            $string = str_ireplace($matches[0][$i], '', $string);
        }

        return $string;
    }

    protected function handleTableSanity($string, $rowCount, $rowSizes)
    {
        $rowPattern = '';

        for ($i = 0; $i < $rowCount; $i++) {
            $rowPattern .= '(.*?<th>.*?<\\/th>.*?\n?)';
        }

        $pattern = '#<thead>.*?\n?.*?<tr>.*?\n?'.$rowPattern.'.*?<\\/tr>.*?\n?.*?<\\/thead>#i';
        $matches = [];
        @preg_match_all($pattern, $string, $matches);

        $strSearch = [];
        $strReplace = [];

        for ($i = 0; $i < count($matches[0]); $i++) {
            foreach (range(1, $rowCount) as $rowI) {
                if (!in_array($matches[$rowI][$i], $strSearch)) {
                    $strSearch[] = $matches[$rowI][$i];
                    $strReplace[] = str_ireplace('<th>', '<th width="'.$rowSizes[$rowI-1].'%">', $matches[$rowI][$i]);
                }
            }
        }

        for ($i = 0; $i < count($strSearch); $i++) {
            $string = str_ireplace($strSearch[$i], $strReplace[$i], $string);
        }

        return $string;
    }
}

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
use \Sundown;

/**
 * Class SwimParserMarkdown
 */
class SwimMarkdownStep extends AbstractSwimParserHandlerType
{
    /**
     * @param  null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
    	$markdown = $this->getContainer()->get('kwattro_markdown');

        return $markdown->render($string);
    }
}

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
use SplSubject;

/**
 * Class SwimParserToc
 */
class SwimParserToc extends SwimParserObserver implements ParserInterface, ContainerAwareInterface
{
    /**
     * @var string
     */
    private $toc = '';

    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        $level1   = [];
        $level2   = [];
        $level3   = [];
        $loop     = 0;
        $currentH = 0;
        $topH     = 1;
        $innerI   = 0;

        $pattern = '#<h(?<h>[0-9])>(.*?)</h\k<h>>#i';
        preg_match_all($pattern, $string, $matches);

        for ($i = 0; $i < count($matches[0]); $i++) {
            $h = $matches['h'][$i];
            if ($i === 0) {
                $topH = $h;
            }
            $outer = $matches[0][$i];
            $inner = $matches[2][$i];
            if ($currentH > $h || $h == $topH) {
                $loop++;
                $innerI = 0;
            }
            if($currentH != $h) {
            }
            $currentH = $h;
            $id = 'toc-'.$loop.'-'.$innerI;
            if ($h == $topH) {
                $level1[$loop][$id] = $inner;
            } elseif ($h == ($topH+1)) {
                $level2[$loop][$id] = $inner;
            } elseif ($h == ($topH+2)) {
                $level3[$loop][$id] = $inner;
            }
            $innerI++;

            $stringSearch = $outer;
            $stringReplace = '<h'.$h.' id="'.$id.'" class="fixedfix">'.$inner.' <small class="toc-top" data-toggle="tooltip" title="Back to Top"><a href="#Top"><i class="icon-arrow-up"> </i></a></small></h'.$h.'>';
            $string = str_replace($stringSearch, $stringReplace, $string);
        }

	if (!count($level1) > 0 ) {
		return [$string, ''];
	}

        $tocHtml = '<div id="node-toc" class="node-toc panel panel-default">
                    <div data-toggle="collapse" data-target="#toc-collapse" class="panel-heading" data-target=".node-toc-l1">
                        <i class="icon-reorder icon-fixed-width"></i> Contents
                        <span class="pull-right"></span>
                    </div>'.
                   '<div id="toc-collapse-off"><ul class="node-toc-l1">';
        //print_r($level1);
        //print_r($level2);
        $j = 0;

        for( $i = 1; $i <= count($level1); $i++ ) {
            $l1k = array_keys($level1[$i])[0];
            $l1v = array_values($level1[$i])[0];

            $tocHtml .= '<li><a href="#'.$l1k.'">';

            $lv1Matches = [];
            @preg_match_all('#<span.*?>\s?</span>\s?#i', $l1v, $lv1Matches);

            if (count($lv1Matches[0]) > 0) {
                 $l1v = str_ireplace($lv1Matches[0][0], '', $l1v);
            }


            $tocHtml .= $l1v.'</a>';
            if (isset($level2[$i]) && is_array($level2[$i])) {
                $tocHtml .= '<ul class="node-toc-l2">';
                foreach ($level2[$i] as $l2k => $l2v) {
                    $lv2Matches = [];
                    @preg_match_all('#<span.*?>\s?</span>\s?#i', $l2v, $lv2Matches);
                    //print_r($lv2Matches);

                    if (count($lv2Matches[0]) > 0) {
                        for ($j=0; $j<sizeof($lv2Matches[0]); $j++) {
                            $l2v = str_ireplace($lv2Matches[0][$j], '', $l2v);
                        }
                    }
                    $tocHtml .= '<li><a href="#'.$l2k.'">'.$l2v.'</a></li>';
                    $j++;
                }
                $tocHtml .= '</ul>';
            }
            $tocHtml .= '</li>';

            $j++;
        }
        $tocHtml .= '</ul></div></div>';
        
        if ($j > 18) {
            $tocHtml = str_ireplace(
                'id="toc-collapse-off"', 
                'id="toc-collapse" class="collapse collapse-large in"', 
                $tocHtml
            );
            $tocHtml = str_ireplace(
                '<span class="pull-right"></span>', 
                '<span class="pull-right mute">Click to show/hide contents</span>', 
                $tocHtml
            );
        } else {
            $tocHtml = str_ireplace(
                'id="toc-collapse-off"', 
                'id="toc-collapse" class="collapse in"', 
                $tocHtml
            );
            $tocHtml = str_ireplace(
                '<span class="pull-right"></span>', 
                '<span class="pull-right mute">Click to show/hide contents</span>', 
                $tocHtml
            );
        }

        $levels = [
            $level1,
            $level2
        ];
            
        return [
            $string, 
            $tocHtml
        ];
    }

    /**
     * @param SplSubject $subject
     * @return $this
     */
    public function update(SplSubject $subject)
    {
        $content = $subject->getContent();
        list($content, $levels) = @$this->render($content);
        
        $withToc = '<div class="nodeToc">'.$levels.'</div>'.
                   '<div class="nodeContent">'.$content.'</div>';

        $subject->setContent($withToc);
        //$subject->setOther('toc', $levels);

        return $this;
    }
}

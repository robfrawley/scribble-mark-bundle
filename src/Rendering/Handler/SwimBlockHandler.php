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

use Scribe\SecurityBundle\Entity\User;
use Scribe\SecurityBundle\Entity\Org;

/**
 * Class SwimBlockHandler
 */
class SwimBlockHandler extends AbstractSwimRenderingHandler
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string, array $args = [])
    {
        $matches = [];
        @preg_match_all('#{~block:(.*?)}((.*\n)*?){~block:end}#i', $string, $matches);

        for ($i = 0; $i < count($matches[0]); $i++) {
            $original    = $matches[0][$i];
            $code        = explode('|', $matches[1][$i]);
            $content     = $matches[2][$i];

            $replace = $this->determineBlockVisibility($code, $content);

            $string = str_replace($original, $replace, $string);
        }

        return $string;
    }

    /**
     * @param $code string
     * @param $content string
     * @return string|null
     */
    protected function determineBlockVisibility($code, $content = '')
    {
        $security = $this
            ->getContainer()
            ->get('security.context')
        ;
        $token = $security
            ->getToken()
        ;

        if ($token === null) {
            return;
        }
        $user = $token->getUser();

        if (! $user instanceof User) {
            return;
        }
        $orgRepository = $this
            ->em
            ->getRepository('ScribeSecurityBundle:Org')
        ;

        foreach ($code as $c) {
            $org = $orgRepository->findByCode($c);

            if (count($org) === 1 && $org[0] instanceof Org) {
                $org = $org[0];

                if ($org->hasManager($user) || $org->hasUser($user)) {
                    return $content;
                }
            }
        }
        return;
    }
}

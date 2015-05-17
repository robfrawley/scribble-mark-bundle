<?php

/*
 * This file is part of the Scribe Symfony Swim Application.
 *
 * (c) Scribe Inc. <https://scribe.software>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\SwimBundle\Rendering\Handler;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Scribe\SecurityBundle\Entity\User;
use Scribe\SecurityBundle\Entity\Org;
use Scribe\SecurityBundle\Entity\OrgRepository;

/**
 * Class SwimBlockRestrictionsHandler.
 */
class SwimBlockRestrictionsHandler extends AbstractSwimRenderingHandler
{
    /**
     * @var AuthorizationCheckerInterface $authorizationChecker
     */
    private $authorizationChecker;

    /**
     * @var TokenStorageInterface $tokenStorage
     */
    private $tokenStorage;

    /**
     * @var OrgRepository|EntityRepository|null
     */
    private $orgRepo;

    /**
     * @param AuthorizationCheckerInterface       $authorizationChecker
     * @param TokenStorageInterface               $tokenStorage
     * @param OrgRepository|EntityRepository|null $orgRepo
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker, TokenStorageInterface $tokenStorage,
                                EntityRepository $orgRepo = null)
    {
        $this->authorizationChecker = $authorizationChecker;
        $this->tokenStorage = $tokenStorage;
        $this->orgRepo = $orgRepo;
    }

    /**
     * @return string
     */
    public function getCategory()
    {
        return self::CATEGORY_BLOCK_RESTRICTIONS;
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

        $this->handleBlockRestrictions(
            $string,
            '#{~block:(.*?)}((.*\n)*?){~block:end}#i',
            [$this, 'isOrgRestrictionMet']
        );
        $this->handleBlockRestrictions(
            $string,
            '#{~restrict:by_org:(.*?)}((.*\n)*?){~block:end}#i',
            [$this, 'isOrgRestrictionMet']
        );
        $this->handleBlockRestrictions(
            $string,
            '#{~restrict:by_role:(.*?)}((.*\n)*?){~block:end}#i',
            [$this, 'isRoleRestrictionMet']
        );

        $this->stopwatchStop($this->getType());

        return $string;
    }

    /**
     * @param string   $string
     * @param string   $regularExpression
     * @param callable $areRestrictionsMet
     */
    private function handleBlockRestrictions(&$string, $regularExpression, callable $areRestrictionsMet)
    {
        if ((false === preg_match_all($regularExpression, $string, $matches)) ||
            (false === is_array($matches) || 3 !== count($matches) || 0 === count($matches[0]))) {
            return;
        }

        $matchesOriginalStr = $matches[0];
        $matchesRestriction = $matches[1];

        foreach(range(0, count($matchesOriginalStr) - 1) as $i) {
            $restrictionSet = (array) explode('|', $matchesRestriction[$i]);

            if (true === $areRestrictionsMet($restrictionSet)) {
                continue;
            }

            $string = str_replace($matchesOriginalStr[$i], '', $string);
        }
    }

    /**
     * @param array $organizationCodes
     *
     * @return bool
     */
    protected function isOrgRestrictionMet(array $organizationCodes)
    {
        if (false === $this->authorizationChecker->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return false;
        }

        if (true === $this->authorizationChecker->isGranted('ROLE_ROOT')) {
            return true;
        }

        if (null === $this->orgRepo) {
            return false;
        }

        foreach ($organizationCodes as $code) {
            $organization = $this->orgRepo->findOneByCode($code);

            if (true === $this->authorizationChecker->isGranted('IS_ORGANIZATION_MANAGER', $organization)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $roleSet
     *
     * @return bool
     */
    protected function isRoleRestrictionMet(array $roleSet)
    {
        if (true === $this->authorizationChecker->isGranted('ROLE_ROOT')) {
            return true;
        }

        foreach ($roleSet as $role) {
            if (true === $this->authorizationChecker->isGranted($role)) {
                return true;
            }
        }

        return false;
    }
}

/* EOF */

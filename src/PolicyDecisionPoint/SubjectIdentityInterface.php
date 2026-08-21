<?php

namespace Oka\PDPAuthorizationBundle\PolicyDecisionPoint;

use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
interface SubjectIdentityInterface extends UserInterface
{
    public function getSubjectType(): string;

    public function getSubjectIdentifier(): string;
}

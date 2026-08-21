<?php

namespace Oka\PDPAuthorizationBundle\PolicyDecisionPoint;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
interface ResourceIdentityInterface
{
    public function getResourceUrn(): string;
}

<?php

namespace Oka\PDPAuthorizationBundle\PolicyDecisionPoint\Provider;

use Oka\PDPAuthorizationBundle\PolicyDecisionPoint\ResourceIdentityInterface;
use Oka\PDPAuthorizationBundle\PolicyDecisionPoint\SubjectIdentityInterface;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
interface PolicyDecisionPointProviderInterface
{
    public function authorize(string $action, SubjectIdentityInterface $subject, ?ResourceIdentityInterface $resource = null): bool;
}

<?php

namespace Oka\PDPAuthorizationBundle\Test\Model;

use Oka\PDPAuthorizationBundle\PolicyDecisionPoint\ResourceIdentityInterface;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class Resource implements ResourceIdentityInterface
{
    public function __construct(
        public string $id,
    ) {
    }

    public function getResourceUrn(): string
    {
        return sprintf('urn:pdp:9ae7a5e0-9c08-11f1-9226-bdb6948ff287:resource/%s', $this->id);
    }
}

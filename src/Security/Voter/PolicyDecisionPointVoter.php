<?php

namespace Oka\PDPAuthorizationBundle\Security\Voter;

use Oka\PDPAuthorizationBundle\PolicyDecisionPoint\Provider\PolicyDecisionPointProviderInterface;
use Oka\PDPAuthorizationBundle\PolicyDecisionPoint\ResourceIdentityInterface;
use Oka\PDPAuthorizationBundle\PolicyDecisionPoint\SubjectIdentityInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\CacheableVoterInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Vote;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class PolicyDecisionPointVoter implements VoterInterface, CacheableVoterInterface
{
    public function __construct(private iterable $providers)
    {
    }

    public function addProvider(PolicyDecisionPointProviderInterface $provider): self
    {
        $this->providers[] = $provider;

        return $this;
    }

    public function supportsAttribute(string $attribute): bool
    {
        return true;
    }

    public function supportsType(string $subjectType): bool
    {
        return 'null' === $subjectType || is_subclass_of($subjectType, ResourceIdentityInterface::class);
    }

    public function vote(TokenInterface $token, mixed $subject, array $attributes, ?Vote $vote = null): int
    {
        // abstain vote by default in case none of the subject and the resource are supported
        $voteResult = self::ACCESS_ABSTAIN;
        $user = $token->getUser();

        if ($user instanceof SubjectIdentityInterface && (null === $subject || $subject instanceof ResourceIdentityInterface)) {
            foreach ($attributes as $attribute) {
                // as soon as at least one attribute is supported, default is to deny access
                $voteResult = self::ACCESS_DENIED;

                /** @var PolicyDecisionPointProviderInterface $provider */
                foreach ($this->providers as $provider) {
                    if ($provider->authorize($attribute, $user, $subject)) {
                        $vote?->addReason(\sprintf('The user has "%s".', $attribute));
                        $voteResult = self::ACCESS_GRANTED;
                        continue;
                    }

                    $vote?->addReason(\sprintf('The user doesn\'t have "%s".', $attribute));
                }
            }
        }

        if (null !== $vote) {
            $vote->result = $voteResult;
        }

        return $voteResult;
    }
}

<?php

namespace Oka\PDPAuthorizationBundle\Tests\Security;

use Oka\PDPAuthorizationBundle\PolicyDecisionPoint\SubjectIdentityInterface;
use Symfony\Component\Security\Core\Exception\DisabledException;

class InMemoryUser implements SubjectIdentityInterface
{
    private string $username;

    public function __construct(
        ?string $username,
        private ?string $password,
        private array $roles = [],
        private bool $enabled = true,
    ) {
        if ('' === $username || null === $username) {
            throw new \InvalidArgumentException('The username cannot be empty.');
        }

        $this->username = $username;
    }

    public function __toString(): string
    {
        return $this->getUserIdentifier();
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * Returns the identifier for this user (e.g. its username or email address).
     */
    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    /**
     * Checks whether the user is enabled.
     *
     * Internally, if this method returns false, the authentication system
     * will throw a DisabledException and prevent login.
     *
     * @return bool true if the user is enabled, false otherwise
     *
     * @see DisabledException
     */
    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @deprecated since Symfony 7.3
     */
    #[\Deprecated(since: 'symfony/security-core 7.3')]
    public function eraseCredentials(): void
    {
        if (\PHP_VERSION_ID < 80400) {
            @trigger_error(\sprintf('Method %s::eraseCredentials() is deprecated since symfony/security-core 7.3', self::class), \E_USER_DEPRECATED);
        }
    }

    public function getSubjectType(): string
    {
        return 'user';
    }

    public function getSubjectIdentifier(): string
    {
        return '9ae7a5e0-9c08-11f1-9226-bdb6948ff287';
    }
}

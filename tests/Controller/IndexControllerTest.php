<?php

namespace Oka\PDPAuthorizationBundle\Tests\Controller;

use Oka\PDPAuthorizationBundle\Tests\Security\InMemoryUser;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IndexControllerTest extends WebTestCase
{
    /**
     * @var KernelBrowser
     */
    protected $client;

    /**
     * @covers
     */
    public function testThatCanInvokeMe(): void
    {
        $this->client->loginUser(new InMemoryUser('user', 'password123', ['ROLE_USER']));
        $this->client->request('GET', '/me');

        $this->assertResponseIsSuccessful();
    }

    /**
     * @covers
     */
    public function testThatCanInvokeAdmin(): void
    {
        $this->client->loginUser(new InMemoryUser('admin', 'password123', ['ROLE_ADMIN']));
        $this->client->request('GET', '/admin');

        $this->assertResponseIsSuccessful();
    }

    /**
     * @covers
     */
    public function testThatCanInvokeAnonymous(): void
    {
        $this->client->request('GET', '/anonymous');

        $this->assertResponseIsSuccessful();
    }

    /**
     * @covers
     */
    public function testThatCannotInvokeAdmin(): void
    {
        $this->client->request('GET', '/admin');
        $this->assertResponseStatusCodeSame(401);

        $this->client->loginUser(new InMemoryUser('user', 'password123', ['ROLE_USER']));
        $this->client->request('GET', '/admin');
        $this->assertResponseStatusCodeSame(401);
    }

    protected function setUp(): void
    {
        static::ensureKernelShutdown();
        $this->client = static::createClient();
    }
}

<?php

namespace Oka\PDPAuthorizationBundle\Tests\Controller;

use Oka\PDPAuthorizationBundle\Test\Security\InMemoryUser;
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
     *
     * @depends testThatCanInvokeMe
     */
    public function testThatCanReadResource(): void
    {
        $this->client->loginUser(new InMemoryUser('user', 'password123', ['ROLE_USER']));
        $this->client->request('GET', '/resources?id=77f54db0-d8fc-11ef-9838-0242ac12001f');

        $this->assertResponseIsSuccessful();
    }

    /**
     * @covers
     *
     * @depends testThatCanReadResource
     */
    public function testThatCanInvokeAdmin(): void
    {
        $this->client->loginUser(new InMemoryUser('admin', 'password123', ['ROLE_ADMIN']));
        $this->client->request('GET', '/admin');

        $this->assertResponseIsSuccessful();
    }

    /**
     * @covers
     *
     * @depends testThatCanInvokeAdmin
     */
    public function testThatCannotInvokeAdmin(): void
    {
        $this->client->request('GET', '/admin');
        $this->assertResponseStatusCodeSame(401);

        $this->client->loginUser(new InMemoryUser('user', 'password123', ['ROLE_USER']));
        $this->client->request('GET', '/admin');
        $this->assertResponseStatusCodeSame(401);
    }

    /**
     * @covers
     *
     * @depends testThatCannotInvokeAdmin
     */
    public function testThatCanInvokeAnonymous(): void
    {
        $this->client->request('GET', '/anonymous');

        $this->assertResponseIsSuccessful();
    }

    protected function setUp(): void
    {
        static::ensureKernelShutdown();
        $this->client = static::createClient();
    }
}

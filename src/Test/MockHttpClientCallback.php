<?php

namespace Oka\PDPAuthorizationBundle\Test;

use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class MockHttpClientCallback
{
    public function __invoke(string $method, string $url, array $options = []): ResponseInterface
    {
        switch (true) {
            case 'POST' === $method && str_ends_with($url, '/v1/data/authz/allow') && in_array('ROLE_ADMIN', json_decode($options['body'], true)['input']['subject']['roles']):
                return new MockResponse('{"result": true}', ['http_code' => 200]);

            default:
                return new MockResponse('{"result": false}', ['http_code' => 200]);
        }
    }
}

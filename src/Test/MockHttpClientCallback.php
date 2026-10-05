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
        $body = json_decode($options['body'], true);

        switch (true) {
            case 'POST' === $method && str_ends_with($url, '/v1/data/authz/allow') && in_array('ROLE_ADMIN', $body['input']['subject']['roles']):
                return new MockResponse('{"result": true}', ['http_code' => 200]);

            case 'POST' === $method && str_ends_with($url, '/v1/data/authz/allow')
                && '9ae7a5e0-9c08-11f1-9226-bdb6948ff287' === $body['input']['subject']['id']
                && 'urn:pdp:9ae7a5e0-9c08-11f1-9226-bdb6948ff287:resource/77f54db0-d8fc-11ef-9838-0242ac12001f' === $body['input']['resource']['urn']:
                return new MockResponse('{"result": true}', ['http_code' => 200]);

            default:
                return new MockResponse('{"result": false}', ['http_code' => 200]);
        }
    }
}

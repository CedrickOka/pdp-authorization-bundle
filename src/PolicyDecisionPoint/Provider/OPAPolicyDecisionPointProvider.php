<?php

namespace Oka\PDPAuthorizationBundle\PolicyDecisionPoint\Provider;

use Oka\PDPAuthorizationBundle\PolicyDecisionPoint\ResourceIdentityInterface;
use Oka\PDPAuthorizationBundle\PolicyDecisionPoint\SubjectIdentityInterface;
use Symfony\Contracts\HttpClient\Exception\ExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class OPAPolicyDecisionPointProvider implements PolicyDecisionPointProviderInterface
{
    public function __construct(
        private HttpClientInterface $httpClient,
        private string $policyUrl,
        private int $timeout,
        private int $retryMaxAttempts,
    ) {
    }

    public function authorize(string $action, SubjectIdentityInterface $subject, ?ResourceIdentityInterface $resource = null): bool
    {
        $input = [
            'subject' => [
                'id' => $subject->getSubjectIdentifier(),
                'type' => $subject->getSubjectType(),
                'roles' => $subject->getRoles(),
            ],
            'action' => $action,
        ];

        if (null !== $resource) {
            $input['resource'] = [
                'urn' => $resource->getResourceUrn(),
            ];
        }

        $response = $this->httpClient->request(
            'POST',
            $this->policyUrl,
            [
                'timeout' => $this->timeout,
                'json' => [
                    'input' => $input,
                ],
            ]
        );

        try {
            $data = $response->toArray();
        } catch (ExceptionInterface $e) {
            return false;
        }

        // OPA policies typically return a boolean 'result'
        return $data['result'] ?? false;
    }
}

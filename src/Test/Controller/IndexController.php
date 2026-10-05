<?php

namespace Oka\PDPAuthorizationBundle\Test\Controller;

use Oka\PDPAuthorizationBundle\Test\Model\Resource;
use Oka\PDPAuthorizationBundle\Test\Security\InMemoryUser;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryString;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class IndexController
{
    #[Route(name: 'me', path: '/me')]
    public function me(): Response
    {
        return new Response('', 204);
    }

    #[Route(name: 'admin', path: '/admin')]
    #[IsGranted('policy.edit', subject: 'user')]
    public function admin(#[CurrentUser()] InMemoryUser $user): Response
    {
        return new Response('', 204);
    }

    #[Route(name: 'resource', path: '/resources')]
    public function resource(
        #[MapQueryString()] Resource $resource,
        Security $security,
    ): Response {
        if (!$security->isGranted('policy.read', $resource)) {
            throw new AccessDeniedHttpException();
        }

        return new Response('', 204);
    }

    #[Route(name: 'anonymous', path: '/anonymous')]
    public function anonymous(): Response
    {
        return new Response('', 204);
    }
}

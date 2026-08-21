<?php

namespace Oka\PDPAuthorizationBundle\Test\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
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
    #[IsGranted('policy.edit')]
    public function admin(): Response
    {
        return new Response('', 204);
    }

    #[Route(name: 'anonymous', path: '/anonymous')]
    public function anonymous(): Response
    {
        return new Response('', 204);
    }
}

<?php

namespace Oka\PDPAuthorizationBundle;

use Oka\PDPAuthorizationBundle\DependencyInjection\Compiler\PolicyDecisionPointProviderPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class OkaPDPAuthorizationBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new PolicyDecisionPointProviderPass());
    }
}

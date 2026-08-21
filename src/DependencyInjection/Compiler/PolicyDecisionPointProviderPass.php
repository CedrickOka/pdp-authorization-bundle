<?php

namespace Oka\PDPAuthorizationBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author Cedrick Oka Baidai <okacedrick@gmail.com>
 */
class PolicyDecisionPointProviderPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $definition = $container->getDefinition('oka_pdp_authorization.policy_decision_point.security.voter');

        foreach ($container->findTaggedServiceIds('oka_pdp_authorization.provider') as $id => $tags) {
            $definition->addMethodCall('addProvider', [new Reference($id)]);
        }
    }
}

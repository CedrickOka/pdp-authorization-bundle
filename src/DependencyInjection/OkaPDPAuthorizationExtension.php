<?php

namespace Oka\PDPAuthorizationBundle\DependencyInjection;

use Oka\PDPAuthorizationBundle\PolicyDecisionPoint\Provider\OPAPolicyDecisionPointProvider;
use Oka\PDPAuthorizationBundle\PolicyDecisionPoint\Provider\PolicyDecisionPointProviderInterface;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class OkaPDPAuthorizationExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('services.yml');

        if (true === $config['open_policy_agent']['enabled']) {
            $container
            ->setDefinition(
                'oka_pdp_authorization.provider.open_policy_agent',
                new Definition(
                    OPAPolicyDecisionPointProvider::class,
                    [
                        new Reference('http_client'),
                        $config['open_policy_agent']['policy_url'],
                        $config['open_policy_agent']['timeout'],
                        $config['open_policy_agent']['retry_max_attempts'],
                    ]
                )
            )
            ->addTag('oka_pdp_authorization.provider');
            $container->setAlias(OPAPolicyDecisionPointProvider::class, 'oka_pdp_authorization.provider.open_policy_agent');
        }

        $container
            ->registerForAutoconfiguration(PolicyDecisionPointProviderInterface::class)
            ->addTag('oka_pdp_authorization.provider');
    }
}

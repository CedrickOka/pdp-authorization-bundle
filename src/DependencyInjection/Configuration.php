<?php

namespace Oka\PDPAuthorizationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('oka_pdp_authorization');
        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                ->arrayNode('open_policy_agent')
                    ->canBeEnabled()
                    ->children()
                        ->stringNode('policy_url')->isRequired()->end()
                        ->integerNode('timeout')->defaultValue(1)->end()
                        ->integerNode('retry_max_attempts')->defaultValue(0)->end()
                    ->end()
                ->end()
//                 ->arrayNode('providers')
//                     ->cannotBeEmpty()
// //                     ->requiresAtLeastOneElement()
// //                     ->validate()
// //                         ->ifTrue(static function ($v) {
// //                             foreach ($v as $key => $config) {
// //                                 foreach ($config['sort']['order'] as $filterName => $direction) {
// //                                     if (false === array_key_exists($filterName, $config['filters'])) {
// //                                         return true;
// //                                     }
// //                                 }
// //                             }

// //                             return false;
// //                         })
// //                         ->thenInvalid('The configuration value "oka_pdp_authorization.providers.*.sort.order" must only contains keys that matches to filter names %s.')
// //                     ->end()
//                     ->stringPrototype()
//                     ->end()
//                 ->end()
            ->end();

        return $treeBuilder;
    }
}

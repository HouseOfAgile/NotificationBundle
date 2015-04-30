<?php

namespace HOA\Bundle\NotificationBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('hoa_notification');

        $rootNode
            ->children()
                ->arrayNode('sms_service')
                ->addDefaultsIfNotSet()
                ->children()
                    ->booleanNode('active')->end()
                    ->arrayNode('twilio')
                        ->addDefaultsIfNotSet()

                        ->children()
                            ->scalarNode('sid')
                            ->defaultValue(null)
                            ->end()
                            ->scalarNode('authToken')
                            ->defaultValue(null)
                            ->end()
                            ->scalarNode('version')
                            ->defaultValue(null)
                            ->end()
                            ->scalarNode('retryAttempts')
                            ->defaultValue(null)
                            ->end()
                            ->scalarNode('outboundNumber')
                            ->defaultValue(null)
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('mailer_service')
                ->children()
                    ->booleanNode('active')
                        ->defaultTrue()
                    ->end()
                    ->scalarNode('hoa_from_email')
                        ->defaultValue(null)
                        ->cannotBeEmpty()
                    ->end()
                    ->scalarNode('hoa_bcc_email')
                        ->defaultValue(null)
                        ->cannotBeEmpty()
                    ->end()
                ->end()
            ->end()
        ->end();
        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}

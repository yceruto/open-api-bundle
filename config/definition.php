<?php

use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;

return static function (DefinitionConfigurator $configurator): void {
    $configurator->rootNode()
        ->children()
            ->arrayNode('generator')
                ->addDefaultsIfNotSet()
                ->children()
                    ->arrayNode('scan_dirs')
                        ->defaultValue(['%kernel.project_dir%/src/'])
                        ->scalarPrototype()->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode('spec')
                ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode('openapi')
                        ->isRequired()
                        ->defaultValue('3.1.0')
                        ->cannotBeEmpty()
                    ->end()
                    ->arrayNode('info')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('title')
                                ->isRequired()
                                ->defaultValue('API Documentation')
                                ->cannotBeEmpty()
                            ->end()
                            ->scalarNode('summary')->end()
                            ->scalarNode('description')->end()
                            ->scalarNode('termsOfService')->end()
                            ->arrayNode('contact')
                                ->children()
                                    ->scalarNode('name')->end()
                                    ->scalarNode('url')->end()
                                    ->scalarNode('email')->end()
                                ->end()
                            ->end()
                            ->arrayNode('license')
                                ->children()
                                    ->scalarNode('name')->isRequired()->end()
                                    ->scalarNode('identifier')->defaultNull()->end()
                                    ->scalarNode('url')->defaultNull()->end()
                                ->end()
                            ->end()
                            ->scalarNode('version')
                                ->isRequired()
                                ->defaultValue('1.0.0')
                                ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode('servers')
                        ->arrayPrototype()
                            ->children()
                                ->scalarNode('url')
                                    ->isRequired()
                                    ->defaultValue('/')
                                    ->cannotBeEmpty()
                                ->end()
                                ->scalarNode('description')
                                    ->defaultNull()
                                ->end()
                                ->arrayNode('variables')
                                    ->useAttributeAsKey('name')
                                    ->arrayPrototype()
                                        ->children()
                                            ->arrayNode('enum')
                                                ->scalarPrototype()
                                                    ->cannotBeEmpty()
                                                ->end()
                                            ->end()
                                            ->scalarNode('default')
                                                ->isRequired()
                                            ->end()
                                            ->scalarNode('description')
                                                ->defaultNull()
                                            ->end()
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end()
    ->end();
};

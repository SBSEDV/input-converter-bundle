<?php declare(strict_types=1);

namespace Symfony\Component\Config\Definition\Configurator;

return function (DefinitionConfigurator $definition): void {
    $definition
        ->rootNode()
            ->children()
                ->arrayNode('json_converter')
                    ->treatTrueLike(['enabled' => true])
                    ->treatFalseLike(['enabled' => false])
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultValue(!\extension_loaded('json_post'))
                        ->end()
                        ->arrayNode('content_types')
                            ->info('The Content-Type headers on which this converter should act upon.')
                            ->prototype('scalar')->end()
                            ->defaultValue(['application/json'])
                        ->end()
                        ->arrayNode('methods')
                            ->info('The HTTP-methods on which this converter should act upon.')
                            ->prototype('scalar')->end()
                            ->defaultValue(['POST', 'PUT', 'PATCH', 'DELETE'])
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end()
    ;
};

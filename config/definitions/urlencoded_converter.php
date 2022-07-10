<?php declare(strict_types=1);

namespace Symfony\Component\Config\Definition\Configurator;

return function (DefinitionConfigurator $definition): void {
    $definition
        ->rootNode()
            ->children()
                ->arrayNode('urlencoded_converter')
                    ->treatTrueLike(['enabled' => true])
                    ->treatFalseLike(['enabled' => false])
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->arrayNode('methods')
                            ->info('The HTTP-methods on which this converter should act upon.')
                            ->prototype('scalar')->end()
                            ->defaultValue(['PUT', 'PATCH', 'DELETE'])
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end()
    ;
};

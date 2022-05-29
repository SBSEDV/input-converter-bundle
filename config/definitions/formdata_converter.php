<?php declare(strict_types=1);

namespace Symfony\Component\Config\Definition\Configurator;

return function (DefinitionConfigurator $definition): void {
    $definition
        ->rootNode()
            ->children()
                ->arrayNode('formdata_converter')
                    ->treatTrueLike(['enabled' => true])
                    ->treatFalseLike(['enabled' => false])
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
                        ->arrayNode('methods')
                            ->info('The HTTP-methods on which this converter should act upon.')
                            ->prototype('scalar')->end()
                            ->defaultValue(['PUT', 'PATCH', 'DELETE'])
                        ->end()
                        ->booleanNode('file_support')
                            ->info('Whether file uploads should be used. This is not recommended because of consumed memory.')
                            ->defaultValue(false)
                        ->end()
                    ->end()
                ->end()
            ->end()
        ->end()
    ;
};

<?php declare(strict_types=1);

namespace SBSEDV\Bundle\InputConverterBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sbsedv_input_converter');

        $treeBuilder->getRootNode()
            ->children()
                ->arrayNode('json_converter')
                    ->treatTrueLike(['enabled' => true])
                    ->treatFalseLike(['enabled' => false])
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultTrue()->end()
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
                ->end() // json_converter

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
                ->end() // formdata_converter

                ->arrayNode('urlencoded_converter')
                    ->treatTrueLike(['enabled' => true])
                    ->treatFalseLike(['enabled' => false])
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('enabled')->defaultFalse()->end()
                        ->arrayNode('content_types')
                            ->info('The Content-Type headers on which this converter should act upon.')
                            ->prototype('scalar')->end()
                            ->defaultValue(['application/x-www-urlencoded'])
                        ->end()
                        ->arrayNode('methods')
                            ->info('The HTTP-methods on which this converter should act upon.')
                            ->prototype('scalar')->end()
                            ->defaultValue(['PUT', 'PATCH', 'DELETE'])
                        ->end()
                    ->end()
                ->end() // urlencoded_converter
            ->end()
        ;

        return $treeBuilder;
    }
}

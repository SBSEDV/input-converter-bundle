<?php declare(strict_types=1);

namespace SBSEDV\Bundle\InputConverterBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ConverterInterfaceCompilerPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        $converter = $container->getDefinition('sbsedv_input_converter');

        foreach ($container->findTaggedServiceIds('sbsedv_input_converter.converter') as $serviceId => $tags) {
            $converter->addMethodCall('addConverter', [new Reference($serviceId)]);
        }
    }
}

<?php declare(strict_types=1);

namespace SBSEDV\Bundle\InputConverterBundle\DependencyInjection\Compiler;

use SBSEDV\InputConverter\InputConverter;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class ConverterInterfaceCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $converter = $container->getDefinition(InputConverter::class);

        foreach ($container->findTaggedServiceIds('sbsedv_input_converter.converter') as $serviceId => $tags) {
            $converter->addMethodCall('addConverter', [new Reference($serviceId)]);
        }
    }
}

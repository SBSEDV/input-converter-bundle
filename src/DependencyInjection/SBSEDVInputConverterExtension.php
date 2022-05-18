<?php declare(strict_types=1);

namespace SBSEDV\Bundle\InputConverterBundle\DependencyInjection;

use SBSEDV\Bundle\InputConverterBundle\EventListener\ConvertInputEventListener;
use SBSEDV\Component\InputConverter\Converter\ConverterInterface;
use SBSEDV\Component\InputConverter\Converter\FormData;
use SBSEDV\Component\InputConverter\Converter\JSON;
use SBSEDV\Component\InputConverter\Converter\UrlEncoded;
use SBSEDV\Component\InputConverter\InputConverter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

class SBSEDVInputConverterExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container): void
    {
        $config = $this->processConfiguration(new Configuration(), $configs);

        $container
            ->registerForAutoconfiguration(ConverterInterface::class)
            ->addTag('sbsedv_input_converter.converter')
        ;

        $definition = new Definition(InputConverter::class);

        if ($config['json_converter']['enabled'] === true) {
            $definition->addMethodCall('addConverter', [
                new Definition(JSON::class, [
                    '$contentTypes' => $config['json_converter']['content_types'],
                    '$methods' => $config['json_converter']['methods'],
                ]),
            ]);
        }

        if ($config['urlencoded_converter']['enabled'] === true) {
            $definition->addMethodCall('addConverter', [
                new Definition(UrlEncoded::class, [
                    '$contentTypes' => $config['urlencoded_converter']['content_types'],
                    '$methods' => $config['urlencoded_converter']['methods'],
                ]),
            ]);
        }

        if ($config['formdata_converter']['enabled'] === true) {
            $definition->addMethodCall('addConverter', [
                new Definition(FormData::class, [
                    '$methods' => $config['formdata_converter']['methods'],
                    '$fileSupport' => $config['formdata_converter']['file_support'],
                ]),
            ]);
        }

        $container->setDefinition('sbsedv_input_converter', $definition);
        $container->setAlias(InputConverter::class, 'sbsedv_input_converter');

        $container
            ->setDefinition('sbsedv_input_converter.event_listener', new Definition(ConvertInputEventListener::class))
            ->setArguments([
                '$inputConverter' => new Reference(InputConverter::class),
            ])
            ->addTag('kernel.event_subscriber')
        ;
    }
}

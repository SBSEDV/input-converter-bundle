<?php declare(strict_types=1);

namespace SBSEDV\Bundle\InputConverterBundle;

use SBSEDV\Bundle\InputConverterBundle\DependencyInjection\Compiler\ConverterInterfaceCompilerPass;
use SBSEDV\Component\InputConverter\Converter;
use Symfony\Component\Config\Definition\Configurator\DefinitionConfigurator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class SBSEDVInputConverterBundle extends AbstractBundle
{
    /**
     * {@inheritdoc}
     */
    public function configure(DefinitionConfigurator $definition): void
    {
        $definition->import('../config/definitions/formdata_converter.php');
        $definition->import('../config/definitions/json_converter.php');
        $definition->import('../config/definitions/urlencoded_converter.php');
    }

    /**
     * {@inheritdoc}
     */
    public function loadExtension(array $config, ContainerConfigurator $container, ContainerBuilder $builder): void
    {
        $builder
            ->registerForAutoconfiguration(Converter\ConverterInterface::class)
            ->addTag('sbsedv_input_converter.converter')
        ;

        $container->import('../config/services/main.php');

        if ($config['formdata_converter']['enabled']) {
            $container->import('../config/services/formdata_converter.php');
            $container->services()
                ->get(Converter\FormData::class)
                ->arg('$methods', $config['formdata_converter']['methods'])
                ->arg('$fileSupport', $config['formdata_converter']['file_support'])
            ;
        }

        if ($config['json_converter']['enabled'] === true) {
            $container->import('../config/services/json_converter.php');
            $container->services()
                ->get(Converter\JSON::class)
                ->arg('$contentTypes', $config['json_converter']['content_types'])
                ->arg('$methods', $config['json_converter']['methods'])
            ;
        }

        if ($config['urlencoded_converter']['enabled'] === true) {
            $container->import('../config/services/urlencoded_converter.php');
            $container->services()
                ->get(Converter\UrlEncoded::class)
                ->arg('$contentTypes', $config['urlencoded_converter']['content_types'])
                ->arg('$methods', $config['urlencoded_converter']['methods'])
            ;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new ConverterInterfaceCompilerPass());
    }
}

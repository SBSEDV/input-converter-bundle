<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use SBSEDV\InputConverter\Converter\FormDataConverter;

return function (ContainerConfigurator $container): void {
    $container->services()
        ->set(FormDataConverter::class)
            ->args([
                '$methods' => abstract_arg('The HTTP-methods that this converter should listen to.'),
                '$fileSupport' => abstract_arg('Whether file uploads are supported.'),
            ])
            ->tag('sbsedv_input_converter.converter')
    ;
};

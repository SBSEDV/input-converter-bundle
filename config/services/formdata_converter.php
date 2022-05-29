<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use SBSEDV\Component\InputConverter\Converter\FormData;

return function (ContainerConfigurator $container): void {
    $container->services()
        ->set(FormData::class)
            ->args([
                '$methods' => abstract_arg('The HTTP-methods that this converter should listen to.'),
                '$fileSupport' => abstract_arg('Whether file uploads are supported.'),
            ])
            ->tag('sbsedv_input_converter.converter')
    ;
};

<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use SBSEDV\InputConverter\Converter\UrlEncodedConverter;

return function (ContainerConfigurator $container): void {
    $container->services()
        ->set(UrlEncodedConverter::class)
            ->args([
                '$contentTypes' => abstract_arg('The HTTP-content-types that this converter should listen to.'),
                '$methods' => abstract_arg('The HTTP-methods that this converter should listen to.'),
            ])
            ->tag('sbsedv_input_converter.converter')
    ;
};

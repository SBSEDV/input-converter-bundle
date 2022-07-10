<?php declare(strict_types=1);

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use SBSEDV\Bundle\InputConverterBundle\EventSubscriber\ConvertInputEventSubscriber;
use SBSEDV\InputConverter\InputConverter;

return function (ContainerConfigurator $container): void {
    $container->services()
        ->set(ConvertInputEventSubscriber::class)
            ->args([
                '$inputConverter' => service(InputConverter::class),
            ])
            ->tag('kernel.event_subscriber')

        ->set(InputConverter::class)
    ;
};

<?php declare(strict_types=1);

namespace SBSEDV\Bundle\InputConverterBundle;

use SBSEDV\Bundle\InputConverterBundle\DependencyInjection\Compiler\ConverterInterfaceCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SBSEDVInputConverterBundle extends Bundle
{
    /**
     * {@inheritdoc}
     */
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new ConverterInterfaceCompilerPass());
    }
}

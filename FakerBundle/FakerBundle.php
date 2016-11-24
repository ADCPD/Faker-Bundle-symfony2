<?php

namespace Administration\FakerBundle;

use Administration\FakerBundle\DependencyInjection\Compiler\AddProvidersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class FakerBundle
 * @package Administration\FakerBundle
 *
 *
 * @author William Durand <william.durand1@gmail.com>
 */
class FakerBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new AddProvidersPass());
    }
}

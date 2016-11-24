<?php
/**
 * Created by PhpStorm.
 * User: dhaouadi_a
 * Date: 03/11/2016
 * Time: 16:03
 */

namespace Administration\FakerBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class AddProvidersPass
 * @package Administration\FakerBundle\DependencyInjection\Compiler
 */
class AddProvidersPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('faker.generator')) {
            return;
        }
        foreach ($container->findTaggedServiceIds('faker.provider') as $id => $tags) {
            $container
                ->getDefinition('faker.generator')
                ->addMethodCall('addProvider', array(new Reference($id)));
        }
    }
}
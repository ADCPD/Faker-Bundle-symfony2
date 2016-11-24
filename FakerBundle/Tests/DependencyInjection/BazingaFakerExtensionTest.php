<?php
/**
 * Created by PhpStorm.
 * User: dhaouadi_a
 * Date: 03/11/2016
 * Time: 16:13
 */

namespace Administration\FakerBundle\Tests\DependencyInjection;

use Administration\FakerBundle\DependencyInjection\FakerExtension;
use Administration\FakerBundle\Tests\TestCase;
 use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

/**
 * @author William Durand <william.durand1@gmail.com>
 */
class BazingaFakerExtensionTest extends TestCase
{
    public function getContainer()
    {
        return new ContainerBuilder(new ParameterBag(array(
            'kernel.root_dir' => __DIR__.'/../../',
        )));
    }
    public function testLoadWithCustomPopulator()
    {
        $container = $this->getContainer();
        $loader    = new FakerExtension();
        $loader->load(array(array('populator' => '\Foo\Bar')), $container);
        $this->assertEquals('\Foo\Bar', $container->getParameter('faker.populator.class'));
        try {
            $container->get('faker.populator');
            $this->fail('\Foo\Bar doesn\'t exist so it should throw an exception');
        } catch (\ReflectionException $e) {
            $this->assertEquals('Class \Foo\Bar does not exist', $e->getMessage(), 'Check that the loaded populator is well configured');
        }
    }
}
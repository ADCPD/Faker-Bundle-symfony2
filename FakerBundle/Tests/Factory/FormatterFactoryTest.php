<?php
/**
 * Created by PhpStorm.
 * User: dhaouadi_a
 * Date: 03/11/2016
 * Time: 16:12
 */

namespace Administration\FakerBundle\Tests\Factory;

use Administration\FakerBundle\Tests\TestCase;
use Administration\FakerBundle\Factory\FormatterFactory;

/**
 * Class FormatterFactoryTest
 * @package Administration\FakerBundle\Tests\Factory
 */
class FormatterFactoryTest extends TestCase
{
    public function testCreateClosureWithoutParameters()
    {
        $generator = $this->getMock('Faker\Generator', array('foo'));
        $generator
            ->expects($this->once())
            ->method('foo')
        ;
        $generator
            ->expects($this->never())
            ->method('optional')
        ;
        $closure = FormatterFactory::createClosure($generator, 'foo');
        $this->assertTrue(is_callable($closure));
        $closure();
    }
    public function testCreateClosureWithOptional()
    {
        $generator = $this->getMock('Faker\Generator', array('foo','optional'));
        $generator
            ->expects($this->once())
            ->method('foo')
        ;
        $generator
            ->expects($this->once())
            ->method('optional')
            ->will($this->returnValue($generator))
        ;
        $closure = FormatterFactory::createClosure($generator, 'foo', array(), null, 0.1);
        $this->assertTrue(is_callable($closure));
        $closure();
    }
    public function withParameterProvider()
    {
        return array(
            array(array('1')),
            array(array(true, 1, false, null)),
            array(array('-1 day', '+1 month')),
            array(array('aaaa', 'bbbb', 'cccc')),
        );
    }
    /**
     * @dataProvider withParameterProvider
     */
    public function testCreateClosureWithParameters(array $parameters)
    {
        $generator = $this->getMock('Faker\Generator', array('foo'));
        $matcher = $generator
            ->expects($this->once())
            ->method('foo')
        ;
        call_user_func_array(array($matcher, 'with'), $parameters);
        $closure = FormatterFactory::createClosure($generator, 'foo', $parameters);
        $this->assertTrue(is_callable($closure));
        $closure();
    }
    public function testLiveRandomElement()
    {
        $elements = array('a', 'b');
        $generator = new \Faker\Generator();
        $provider = new \Faker\Provider\Base($generator);
        $generator->addProvider($provider);
        $closure = FormatterFactory::createClosure($generator, 'randomElement', array($elements));
        $this->assertTrue(is_callable($closure));
        $randomElement = $closure();
        $this->assertContains($randomElement, $elements);
    }
    public function testLiveDateTimeBetween()
    {
        $generator = new \Faker\Generator();
        $provider = new \Faker\Provider\DateTime($generator);
        $generator->addProvider($provider);
        $closure = FormatterFactory::createClosure($generator, 'dateTimeBetween', array('-1 day', '+1 day'));
        $this->assertTrue(is_callable($closure));
        $dateTime = $closure();
        $this->assertInstanceOf('DateTime', $dateTime);
        $this->assertTrue($dateTime > new \DateTime('-2 days'));
        $this->assertTrue($dateTime < new \DateTime('+2 days'));
    }
}
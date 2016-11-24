<?php
/**
 * Created by PhpStorm.
 * User: dhaouadi_a
 * Date: 03/11/2016
 * Time: 16:05
 */

namespace Administration\FakerBundle\Factory;

use Faker\Generator;

/**
 * Class FormatterFactory
 * @package Administration\FakerBundle\Factory
 *
 * @author William Durand <william.durand1@gmail.com>
 */
class FormatterFactory
{
    /**
     * @param $generator
     * @param $method
     * @param array $parameters
     * @param bool $unique
     * @param null $optional
     * @return \Closure
     */
    public static function createClosure($generator, $method, array $parameters = array(), $unique = false, $optional = null)
    {
        if ($unique && $generator instanceof Generator) {
            $generator = $generator->unique();
        }
        return function () use ($generator, $method, $parameters, $optional) {
            if (null !== $optional && $generator instanceof Generator) {
                $generator = $generator->optional((double)$optional);
            }
            return call_user_func_array(array($generator, $method), (array)$parameters);
        };
    }
}
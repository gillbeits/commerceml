<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 21.12.15
 * Time: 15:50
 */

namespace CommerceMLParser\Creational;


trait Multiton
{
    /** @var static The stored multiton instances */
    protected static $instance;

    /**
     * @param $name
     * @return static
     */
    public static function getInstance($name)
    {
        return static::getNamedInstance($name);
    }

    public static function getNamedInstance($key = '__DEFAULT__')
    {
        if (!isset(static::$instance[$key])) {
            if (!static::$instance) {
                static::$instance = [];
            }
            static::$instance[$key] = (new \ReflectionClass(get_called_class()))
                ->newInstanceWithoutConstructor();
            call_user_func_array([static::$instance[$key], "__init"], func_get_args());
        }

        return static::$instance[$key];
    }

    /**
     * Init Multiton function
     */
    protected function __init () {}

}

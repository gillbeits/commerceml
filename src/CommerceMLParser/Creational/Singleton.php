<?php
/**
 * Created by PhpStorm.
 * User: Ivan Koretskiy aka gillbeits[at]gmail.com
 * Date: 18/12/15
 * Time: 08:44
 */

namespace CommerceMLParser\Creational;


trait Singleton
{
    /** @var static The stored singleton instance */
    protected static $instance;

    /**
     * Creates the original or retrieves the stored singleton instance
     * @return static
     */
    public static function getInstance()
    {
        if (!static::$instance) {
            static::$instance = (new \ReflectionClass(get_called_class()))
                ->newInstanceWithoutConstructor();
            call_user_func_array([static::$instance, "__init"], func_get_args());
        }

        return static::$instance;
    }

    /**
     * Init Singleton function
     */
    protected function __init () {}

    /**
     * The constructor is disabled
     *
     * @throws \RuntimeException if called
     */
    public function __construct()
    {
        throw new \RuntimeException('You may not explicitly instantiate this object, because it is a singleton.');
    }

    /**
     * Cloning is disabled
     *
     * @throws \RuntimeException if called
     */
    public function __clone()
    {
        throw new \RuntimeException('You may not clone this object, because it is a singleton.');
    }

    /**
     * Unserialization is disabled
     *
     * @throws \RuntimeException if called
     */
    public function __wakeup()
    {
        throw new \RuntimeException('You may not unserialize this object, because it is a singleton.');
    }

    /**
     * Unserialization is disabled
     *
     * @param $serialized_data
     */
    public function unserialize($serialized_data)
    {
        throw new \RuntimeException('You may not unserialize this object, because it is a singleton.');
    }
}
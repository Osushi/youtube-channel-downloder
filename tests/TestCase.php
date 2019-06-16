<?php

namespace Tests;

use \ReflectionClass;
use \ReflectionMethod;
use PHPUnit\Framework\TestCase as Base;

class TestCase extends Base
{
    /**
     * @param mixed $class
     * @param string $method
     * @return ReflectionMethod
     */
    protected static function getMethod(
        $class,
        string $method
    ): ReflectionMethod {
        $class = new ReflectionClass($class);
        $method = $class->getMethod($method);
        $method->setAccessible(true);

        return $method;
    }
}

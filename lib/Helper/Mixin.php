<?php

namespace Press\Helper;


use Press\Request;

/**
 * Class Mixin
 * @package Press\Helper
 */
class Mixin
{
    private static function app($obj)
    {

    }

    /**
     * @param \Swoole\Http\Request $req
     * @throws \ReflectionException
     */
    public static function request(\Swoole\Http\Request $req)
    {
        $reflector = new \ReflectionClass('Press\Request');
        $methods = $reflector->getMethods(\ReflectionMethod::IS_PUBLIC);
        $request = new Request($req);

        foreach ($methods as $method) {
            if ($method->name === '__construct') {
                continue;
            }

            $reflectionMethod = new \ReflectionMethod('Press\Request', $method->name);
            $methodName = $method->name;
            $req->$methodName = $reflectionMethod->invoke($request);
        }

        // init req properties
        ($req->init_properties)();

        var_dump($req);
    }
}
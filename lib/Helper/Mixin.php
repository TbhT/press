<?php

namespace Press\Helper;


use Press\Request;
use Press\Response;

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
    }

    /**
     * @param \Swoole\Http\Response $res
     * @throws \ReflectionException
     */
    public static function response(\Swoole\Http\Response $res)
    {
        $reflector = new \ReflectionClass('Press\Response');
        $methods = $reflector->getMethods(\ReflectionMethod::IS_PUBLIC);
        $request = new Response($res);

        foreach ($methods as $method) {
            if ($method->name === '__construct') {
                continue;
            }

            $reflectionMethod = new \ReflectionMethod('Press\Response', $method->name);
            $methodName = $method->name;
            $res->$methodName = $reflectionMethod->invoke($request);
        }

    }
}
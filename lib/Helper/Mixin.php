<?php

namespace Press\Helper;


use Press\Request;

/**
 * Class Mixin
 * @package Press\Helper
 */
class Mixin
{
    public static function request(\Swoole\Http\Request $req)
    {
        $reflector = new \ReflectionClass('Press\Request');
        $methods = $reflector->getMethods(\ReflectionMethod::IS_PUBLIC);

        foreach ($methods as $method) {
            if ($method->name === '__construct') {
                continue;
            }
            $reflectionMethod = new \ReflectionMethod('Press\Request', $method->name);
            $req->$method = $reflectionMethod->invoke(new Request($req));
        }
    }
}
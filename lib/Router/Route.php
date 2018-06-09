<?php

declare(strict_types=1);


namespace Press\Router;

use function foo\func;
use phpDocumentor\Reflection\Types\Boolean;
use Press\Tool\ArrayHelper;
use Press\Tool\HttpHelper;
use Press\Router\Layer;


class Route
{
    private $path;
    private $stack = [];
    private $methods = [];


    public function __construct($path)
    {
        $this->path = $path;
        $this->VERDSInit();
    }


    private function handles_method(string $method)
    {
        if ($this->methods['all'] === true) {
            return true;
        }

        if ($method === 'head' && empty($this->methods['head'])) {
            $method = 'get';
        }

        return empty($this->methods[$method]);
    }


    private function options()
    {
        if ($this->methods['get'] && empty($this->methods['head'])) {
            $this->methods['head'] = true;
        }

        return array_keys($this->methods);
    }


    public function dispatch(& $req, & $res, callable & $done)
    {
        $index = 0;

        if (count($this->stack) === 0) {
            return $done();
        }

        if ($req['method'] === 'head' && empty($this->methods['head'])) {
            $req['method'] = 'get';
        }

        $req['route'] = $this;

        $next = function ($error = null) use (& $done, & $index, & $req, & $res, & $next) {
//            signal to exit route
            if (empty($error) === false && $error === 'route') {
                return $done();
            }

//          signal to exit router
            if (empty($error) === false && $error === 'router') {
                return $done($error);
            }

            $layer = $this->stack[$index];

            if (empty($layer) || $index >= count($this->stack)) {
                return $done($error);
            }

            if ($layer->method && $layer->method !== $req['method']) {
                return $next($error);
            }

            if ($error) {
                $layer->hanlde_error($error, $req, $res, $next);
            } else {
                $layer->handle_request($req, $res, $next);
            }
        };

        $next();
    }


    public function all(): Route
    {
        $handles = func_get_args();

        array_map(function ($handle) {
            if (is_callable($handle) === false) {
                $type = gettype($handle);
                throw new \TypeError("Route.all() requires a callback function but got a {$type}");
            }

            $layer = new Layer('/', [], $handle);

//            动态添加 method 属性
            $layer->method = null;

            $this->methods['all'] = true;
            array_push($this->stack, $layer);
        }, $handles);

        return $this;
    }


    function __call($name, $arguments)
    {
        if (isset($this->$name)) {
            return call_user_func_array($this->$name, $arguments);
        }
    }


    private function VERDSInit()
    {
        $methods = HttpHelper::methods();

        array_map(function ($method) {
            $this->$method = function () use ($method) {
                $handles = func_get_args();

                array_map(function ($handle) use ($method) {
                    if (is_callable($handle) === false) {
                        $type = gettype($handle);
                        throw new \TypeError("Route.{$method} requires a callback function but get a {$type}");
                    }

                    $layer = new Layer('/', [], $handle);

//                  Layer 动态添加属性
                    $layer->method = $method;

                    $this->methods[$method] = true;
                    array_push($this->stack, $layer);
                }, $handles);

//                链式调用方法
                return $this;
            };
        }, $methods);
    }

}


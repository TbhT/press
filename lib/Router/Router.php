<?php

declare(strict_types=1);


namespace Press\Router;

use Press\Helper\HttpHelper;
use Press\Helper\ArrayHelper;
use Press\Request;
use Press\Response;
use Press\Router\Route;
use Press\Router\Layer;
use Swoole\Timer;


/**
 * Class Router
 * @package Press\Router
 * @property $_params 用来自定义 param 方法
 */
class Router
{
    private $_params = [];
    private $params = [];
    private $caseSensitive;
    private $mergeParams;
    private $strict;
    private $stack = [];


    /**
     * Router constructor.
     * @param array $option
     */
    public function __construct($option = [])
    {
        $this->caseSensitive = $option['caseSensitive'];
        $this->strict = $option['strict'];
        $this->mergeParams = $option['mergeParams'];
    }


    /**
     * @param string $name
     * @param callable $fn
     * @return Router
     */
    public function param(string $name, callable $fn)
    {
        if (is_callable($name)) {
            array_push($this->_params, $name);
            return $this;
        }

        $sub_name = substr($name, 0, 1);
        if ($sub_name === ':') {
            $name = $sub_name;
        }

//        用来自定义 router.param 方法, 只返回一个函数作为param的handle
        foreach ($this->_params as $key => $custom_fn) {
            $ret = $fn($name, $custom_fn);
            if ($ret) {
                $fn = $ret;
            }
        }

        if (is_callable($fn) === false) {
            throw new \Error("Invalid param() call for {$name}, got {$fn}");
        }

        if (is_array($this->params[$name]) === false) {
            $this->params[$name] = [];
        }

        array_push($this->params[$name], $fn);

        return $this;
    }


    public function use()
    {

    }


    public function route()
    {

    }


    private function handle(Request $req,Response $res, &$out)
    {
        $index = 0;
//        $protohost = self::getProtohost($req->url);
        $removed = '';
        $slashAdded = false;
        $paramCalled = [];

//        store options for OPTIONS request only used if OPTIONS request
        $options = [];

//        manage inter-route variables
        $parentParams = &$req->params;
//        $parentUrl = &$req->baseUrl;
//        $done = self::restore($out, $req, 'baseUrl', 'next', 'params');
        $done = $out;
//        $req->next = $next;

        /**
         * @param $error
         * @return mixed
         */
        $next = function ($error = '') use (
            &$slashAdded, &$trim_prefix, &$next, &$index, &$req,
            &$removed, &$protohost, &$done, &$options, &$paramCalled, &$parentParams,
            &$res
        ) {
            $layerError = $error === 'route' ? null : $error;

//            signal to exit router
            if ($layerError === 'router') {
                Timer::after(1, $done);
                return;
            }

            $stack_length = count($this->stack);

//            no more matching layer
            if ($index >= $stack_length) {
                Timer::after(1, function () use ($done, $layerError) {
                    $done($layerError);
                });
                return;
            }

            // get pathname of request
            $path = self::get_path_name($req);

            if (empty($path)) {
                return $done($layerError);
            }

            $layer = null;
            $match = false;
            $route = null;

            while ($match !== true && $index < $stack_length) {
                $layer = $this->stack[$index++];
                $match = self::match_layer($layer, $path);
                $route = $layer->route;

                if (is_bool($match)) {
                    $layerError = $layerError || $match;
                }

                if ($match !== true) {
                    continue;
                }

                if (empty($route)) {
//                process non-route handlers normally
                    continue;
                }

                if ($layerError) {
                    $match = false;
                    continue;
                }

                $method = $req->method;
                $has_method = $route->handles_method($method);

//                build up automatic options response
//                if (!$has_method && $method === 'options') {
//                    self::appendMethods($options, $route->options());
//                }

//                don't even bother matching route
                if (!$has_method && $method !== 'head') {
                    $match = false;
                    continue;
                }
            }

//           no match
            if ($match !== true) {
                return $done($layerError);
            }

//            store route for dispatch on change
            if ($route) {
                $req->route = $route;
            }

            if ($layerError) {
                $layer->handle_error($layerError, $req, $res, $next);
            } else {
                $layer->handle_request($req, $res, $next);
            }

            $next($layerError);
        };

        $next();
    }


    private function merge_params()
    {

    }

    private function process_params()
    {

    }

    private function get_protohost()
    {

    }

    /**
     * @param Request $req
     * @return string
     */
    private function get_path_name(Request $req)
    {
        return $req->server['path_info'];
    }

    /**
     * @param \Press\Router\Layer $layer
     * @param string $path
     * @return bool
     */
    private function match_layer(Layer $layer, string $path)
    {
        return $layer->match($path);
    }
}
<?php

declare(strict_types=1);


namespace Press\Router;

use Press\Tool\HttpHelper;
use Press\Tool\ArrayHelper;
use Press\Router\Route;
use Press\Router\Layer;


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


    public function __construct($option = [])
    {
        $this->caseSensitive = $option['caseSensitive'];
        $this->strict = $option['strict'];
        $this->mergeParams = $option['mergeParams'];
    }


    public function param(string $name, callable $fn)
    {
        if (is_callable($name)) {
            array_push($this->_params, $name);
            return;
        }

        $_name = substr($name, 0, 1);
        if ($_name === ':') {
            $name = $_name;
        }

//        用来自定义 router.param 方法, 只返回一个函数作为param的handle
        foreach ($this->_params as $key => $customFn) {
            if ($ret = $fn($name, $customFn)) {
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


    private function handle(& $req, & $res, & $out)
    {
        $index = 0;
        $protohost = self::getProtohost($req->url);
        $removed = '';
        $slashAdded = false;
        $paramCalled = [];

//        store options for OPTIONS request only used if OPTIONS request
        $options = [];

//        manage inter-route variables
        $parentParams = $req->params;
        $parentUrl = $req->baseUrl;
        $done = self::restore($out, $req, 'baseUrl', 'next', 'params');

//       for options requests, responds with a default if nothing else responds
        if (strtolower($req->method) === 'options') {
            $done = self::wrap($done, function (& $old, $error) use (& $options, & $res) {
                if ($error || count($options) === 0) {
                    return $old($error);
                }

                self::sendOptionsResponse($res, $options, $old);
            });
        }

        $trim_prefix = function ($layer, $layerError, $layerPath, $path) {
            if (count($layerPath) !== 0) {
//                validate path breaks on a path separator

            }
        };

        $next = function ($error) use (& $slashAdded) {
            $layerError = $error === 'route' ? null : $error;

//             remove added slash
            if ($slashAdded) {
                $req->url = substr($req->url, 1);
                $slashAdded = false;
            }

//            restore altered $req->url
            if (count($removed) !== 0) {
                $req->baseUrl = 0;
                $_url = substr($req->url, strlen($protohost));
                $req->url = "{$protohost}{$removed}{$_url}";
                $removed = '';
            }

            $_stack_length = count($this->stack);

//            signal to exit router
            if ($layerError === 'router') {
//                todo 这个地方需要使用 swoole 的eventloop
                return;
            }

//            no more matching layer
            if ($index >= $_stack_length) {
//                todo  这个地方也需要使用 eventloop
                return;
            }

            $path = self::getPathName($req);

            if ($path === null) {
                return $done($layerError);
            }

            $layer = null;
            $match = false;

            while ($match !== true && $index < $_stack_length) {
                $layer = $this->stack[$index++];
                $match = self::matchLayer($layer, $path);
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
                $has_method = $route->_hanldes_method($method);

//                build up automatic options response
                if (!$has_method && $method === 'options') {
                    self::appendMethods($options, $route->options());
                }

//                dont even bother matching route
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

            $req->params = $this->mergeParams ? self::mergeParams() : $layer->params;
            $layerPath = $layer->path;

//            this should be done for the layer
            self::process_params($layer, $paramCalled, $req, $res, function ($error) {
                if ($error) {
                    return $next($layerError || $error);
                }

                if ($route) {
                    return $layer->hanlde_request($req, $res, $next);
                }

                $trim_prefix($layer, $layerError, $layerPath, $path);
            });
        };
    }


    private function process_params()
    {

    }
}
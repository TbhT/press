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

        $length = count($this->_params);
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


    private function handle(& $req, & $res, $out)
    {

    }


    private function process_params()
    {

    }
}
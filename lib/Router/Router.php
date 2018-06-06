<?php

declare(strict_types=1);


namespace Press\Router;

use Press\Tool\HttpHelper;
use Press\Tool\ArrayHelper;
use Press\Router\Route;
use Press\Router\Layer;


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
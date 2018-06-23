<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use PHPUnit\Framework\TestCase;
use Press\Router\Route;
use Press\Tool\HttpHelper;


class RouteTest extends TestCase
{

    public function testWithoutHandlers()
    {
        $req = ['method' => 'GET', 'url' => '/'];
        $res = [];
        $route = new Route('/foo');
        $done = function () {
            $this->assertTrue(true);
        };
        $route->dispatch($req, $res, $done);
    }

    public function testRouteAllMethod()
    {
        $req = ['method' => 'GET', 'url' => '/'];
        $res = [];
        $route = new Route('/foo');
        $done = function ($error) use (& $req) {
            if ($error) {
                $this->assertFalse(false);
                return;
            }

            $this->assertTrue($req['called']);
        };


        $route->all(function ($req, $res, $next) {
            echo 'all 终于被调用了';
            $req['called'] = 1;
            $next();
        });


        $route->dispatch($req, $res, $done);
    }
}
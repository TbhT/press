<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use PHPUnit\Framework\TestCase;
use Press\Router\Route;
use Press\Helper\HttpHelper;


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

    public function testRouteAllAddHandler()
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
            $req['called'] = 1;
            $next();
        });


        $route->dispatch($req, $res, $done);
    }

    public function testRouteAllHandleVERBS()
    {
        $count = 0;
        $route = new Route('/foo');
        $methods = HttpHelper::methods();
        $methodsLength = count($methods);

        $cb = function ($error) use (& $count, $methods) {
            if ($error) {
                return $this->expectException(Exception::class);
            }
        };

        $route->all(function ($req, $res, $next) use (& $count) {
            $count++;
            $next();
        });

        array_map(function ($m) use ($route, $cb, & $count, $methodsLength) {
            $req = ['method' => $m, 'url' => '/'];
            $route->dispatch($req, [], $cb);
        }, $methods);

        $this->assertEquals($methodsLength, $count);
    }

    public function testRouteAllStack()
    {
        $req = ['count' => 0, 'method' => 'GET', 'url' => '/'];
        $route = new Route('/foo');

        $route->all(function ($req, $res, $next) {
            $req['count']++;
            $next();
        });

        $route->all(function ($req, $res, $next) {
            $req['count']++;
            $next();
        });

        $route->dispatch($req, [], function ($error) use ($req) {
            if ($error) {
                return $this->expectException(Exception::class);
            }

            $this->assertEquals(2, $req['count']);
        });
    }
}
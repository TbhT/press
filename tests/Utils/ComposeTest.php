<?php

namespace Utils;

use PHPUnit\Framework\TestCase;
use React\EventLoop\Factory;
use stdClass;
use function React\Promise\resolve;
use function React\Promise\Timer\timeout;
use function Press\Utils\Compose\compose;


class ComposeTest extends TestCase
{
    protected $loop;

    public function setUp(): void
    {
        $this->loop = Factory::create();
    }

    /** @test */
    public function shouldWork()
    {
        $arr = [];
        $stack = [];

        array_push($stack, function ($context, $next) use (&$arr) {
            array_push($arr, 1);
            timeout(resolve(), 1, $this->loop)
                ->otherwise(function () use ($next) {
                    return $next();
                })
                ->then(function () {
                    return timeout(resolve(), 1, $this->loop);
                })
                ->otherwise(function () use (&$arr) {
                    array_push($arr, 6);
                });
        });

        array_push($stack, function ($context, $next) use (&$arr) {
            array_push($arr, 2);
            timeout(resolve(), 1, $this->loop)
                ->otherwise(function () use ($next) {
                    return $next();
                })
                ->then(function () {
                    return timeout(resolve(), 1, $this->loop);
                })
                ->otherwise(function () use (&$arr) {
                    array_push($arr, 5);
                });
        });

        array_push($stack, function ($context, $next) use (&$arr) {
            array_push($arr, 3);
            timeout(resolve(), 1, $this->loop)
                ->otherwise(function () use ($next) {
                    return $next();
                })
                ->then(function () {
                    return timeout(resolve(), 1, $this->loop);
                })
                ->otherwise(function () use (&$arr) {
                    array_push($arr, 4);
                });
        });

        $fn = compose($stack);
        $obj = new stdClass();
        $fn($obj)->then(function () use ($arr) {
            $this->assertSame([1, 2, 3, 4, 5, 6], $arr);
        });
    }
}

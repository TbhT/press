<?php

namespace Press\Tests;

use Press\Utils\Co;
use PHPUnit\Framework\TestCase;
use React\EventLoop\Factory;
use Clue\React\Block;
use React\Promise\Promise;

class CoTest extends TestCase
{
    private $loop;

    public function setUp(): void
    {
        $this->loop = Factory::create();
    }

    private function await($promise)
    {
        try {
            return Block\await($promise, $this->loop);
        } catch (\Exception $e) {
            return null;
        }
    }

    private function work()
    {
        return 'yap';
    }

    /** @test */
    public function shouldWork()
    {
        Block\await(Co\co(function () {
            $a = yield $this->work();
            $b = yield $this->work();

            $this->assertSame('yap', $a);
            $this->assertSame('yap', $b);
        }), $this->loop);
    }

    private function getPromise($val = null, $err = null)
    {
        return new Promise(function ($resolve, $reject) use ($val, $err) {
            if ($err) {
                $reject($err);
            } else {
                $resolve($val);
            }
        });
    }

    /** @test */
    public function shouldWorkWithOnePromiseYield()
    {
        Block\await(Co\co(function () {
            $a = yield $this->getPromise(1);
            $b = yield $this->getPromise(2);
            $c = yield $this->getPromise(3);

            $this->assertSame([1, 2, 3], [$a, $b, $c]);
        }), $this->loop);
    }
}


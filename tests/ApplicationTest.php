<?php

namespace Tests;

use PHPUnit\Framework\MockObject\MockObject;
use Press\Application;
use PHPUnit\Framework\TestCase;
use Press\Context;
use React\Http\Server;
use React\Promise\PromiseInterface;


class ApplicationTest extends TestCase
{
    private $socket;

    private MockObject $connection;

    public function setUp(): void
    {
        $this->connection = $this->getMockBuilder('React\Socket\Connection')
            ->disableOriginalConstructor()
            ->setMethods(
                [
                    'write',
                    'end',
                    'close',
                    'pause',
                    'resume',
                    'isReadable',
                    'isWritable',
                    'getRemoteAddress',
                    'getLocalAddress',
                    'pipe'
                ]
            )
            ->getMock();

        $this->connection->method('isWritable')->willReturn(true);
        $this->connection->method('isReadable')->willReturn(true);

        $this->socket = new SocketServerStub();
    }

    /**  @test */
    public function shouldComposeMiddleware()
    {
        $app = new Application();
        $server = new Server($app->callback());
        $server->listen($this->socket);

        $calls = [];

        $app->use(function (Context $ctx, callable $next) use (&$calls) {
            array_push($calls, 1);
            return $next()->then(function () use (&$calls) {
                array_push($calls, 6);
            });
        });

        $app->use(function (Context $ctx, callable $next) use (&$calls) {
            array_push($calls, 2);
            return $next()->then(function () use (&$calls) {
                array_push($calls, 5);
            });
        });

        $app->use(function (Context $ctx, callable $next) use (&$calls) {
            array_push($calls, 3);
            return $next()->then(function () use (&$calls) {
                array_push($calls, 4);
            });
        });

        $this->socket->emit('connection', array($this->connection));
        $this->connection->emit('data', array("GET / HTTP/1.0\r\n\r\n"));
        $this->assertSame([1, 2, 3, 4, 5, 6], $calls);
    }
}

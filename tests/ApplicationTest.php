<?php

namespace Press\Tests;

use PHPUnit\Framework\MockObject\MockObject;
use Press\Application;
use PHPUnit\Framework\TestCase;
use Press\Context;
use Psr\Http\Message\ResponseInterface;
use React\EventLoop\Factory;
use React\Http\Browser;
use React\Http\Server;
use React\Promise\Promise;


class ApplicationTest extends TestCase
{
    private $socket;

    private $connection;

    private ?Browser $browser;

    private function setApp()
    {
        $app = new Application();
        $server = new Server($app->loop, $app->callback());
        $server->listen($this->socket);
        return $app;
    }

    private function setClientReq()
    {
        $this->socket->emit('connection', array($this->connection));
        $this->connection->emit('data', array("GET / HTTP/1.0\r\n\r\n"));
    }

    /** @before */
    public function setUpConnectionMockAndSocket()
    {
        $this->connection = $this->getMockBuilder('React\Socket\Connection')
            ->disableOriginalConstructor()
            ->setMethods(
                array(
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
                )
            )
            ->getMock();

        $this->connection->method('isWritable')->willReturn(true);
        $this->connection->method('isReadable')->willReturn(true);

        $this->browser = new Browser(Factory::create());

        $this->socket = new SocketServerStub();
    }

    /**  @test */
    public function shouldComposeMiddleware()
    {
        $app = $this->setApp();

        $calls = [];

        $app->use(function (Context $ctx, callable $next) use (&$calls) {
            array_push($calls, 1);
            return $next()->then(function () use (&$calls) {
                array_push($calls, 8);
            });
        });

        $app->use(function (Context $ctx, callable $next) use (&$calls) {
            array_push($calls, 2);
            return $next()->then(function () use (&$calls) {
                array_push($calls, 7);
            });
        });

        $app->use(function (Context $ctx, callable $next) use (&$calls) {
            array_push($calls, 3);
            return $next()->then(function () use (&$calls) {
                array_push($calls, 6);
            });
        });

        $app->use(function (Context $ctx, callable $next) use (&$calls) {
            array_push($calls, 4);
            yield $next;
            array_push($calls, 5);
        });

        $this->setClientReq();
        $this->assertSame([1, 2, 3, 4, 5, 6, 7, 8], $calls);
    }

    /** @test */
    public function shouldComposeMixedMiddleware()
    {
        $this->markTestSkipped('todo mixed middleware');
    }

    /** @test */
    public function contextShouldMergeProperties()
    {
        $app = $this->setApp();

        $app->context->msg = 'hello';
        $app->use(function (Context $ctx, callable $next) {
            $this->assertSame('hello', $ctx->msg);
        });

        $this->setClientReq();
    }

    /** @test */
    public function contextShouldNoEffectToOriginal()
    {
        $app1 = $this->setApp();
        $app2 = $this->setApp();

        $app2->use(function (Context $ctx, callable $next) {
            $this->assertSame(null, $ctx->msg);
        });

        $app1->context->msg = 'hello';

        $this->setClientReq();
    }

    /** @test */
    public function requestShouldMergeProperties()
    {
        $app1 = $this->setApp();

        $app1->request->msg = 'hello';
        $app1->use(function (Context $ctx, callable $next) {
            $this->assertSame('hello', $ctx->request->msg);
        });

        $this->setClientReq();
    }

    /** @test */
    public function requestShouldNoEffectOriginal()
    {
        $app1 = $this->setApp();
        $app2 = $this->setApp();

        $app2->use(function (Context $ctx, callable $next) {
            $this->assertSame(null, $ctx->request->msg);
        });

        $app1->request->msg = 'hello';

        $this->setClientReq();
    }

    /** @test */
    public function responseShouldMergeProperties()
    {
        $app1 = $this->setApp();
        $app1->response->msg = 'hello';

        $app1->use(function (Context $ctx, callable $next) {
            $this->assertSame('hello', $ctx->response->msg);
            $ctx->status = 204;
        });

        $this->setClientReq();
    }

    /** @test */
    public function responseShouldNoEffectOriginal()
    {
        $app1 = $this->setApp();
        $app2 = $this->setApp();

        $app2->use(function (Context $ctx, callable $next) {
            $this->assertSame(null, $ctx->response->msg);
        });

        $app1->response->msg = 'hello';

        $this->setClientReq();
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
    public function shouldWorkWithGenerator()
    {
        $app = $this->setApp();
        $ar = [];

        $app->use(function ($ctx, $next) use (&$ar) {
            $a = yield $this->getPromise(123);
            array_push($ar, $a);

            yield $next;

            $this->assertSame([123, 456, 789], $ar);
        });

        $app->use(function ($ctx, $next) use (&$ar) {
            $b = yield $this->getPromise(456);
            array_push($ar, $b);
        });

        $app->use(function ($ctx, $next) use (&$ar) {
            $c = yield $this->getPromise(789);
            array_push($ar, $c);
        });

        $this->setClientReq();
    }

}

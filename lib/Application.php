<?php


namespace Press;


use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\Http;
use React\Http\Server;
use React\Promise\PromiseInterface;
use function Press\Uitls\Respond\respond;
use function Press\Utils\Compose\compose;


class Application extends Utils\Events
{
    private ?Context $context = null;

    private ?Request $request = null;

    private ?Response $response = null;

    private array $middleware = [];

    private ?LoopInterface $loop = null;

    public function __construct()
    {
        $this->context = new Context();
        $this->request = new Request();
        $this->response = new Response();
        $this->loop = Factory::create();
    }

    public function listen(array $args)
    {
        $host = $args['host'] ?? "0.0.0.0";
        $port = $args['port'] ?? 8080;

        $server = new Server($this->callback());
        $socket = new \React\Socket\Server("{$host}:{$port}", $this->loop);
        $server->listen($socket);
        $this->loop->run();
    }

    public function callback()
    {
        $fn = compose($this->middleware);
        $that = $this;

        $this->on('error', $this->onerror());

        return function (ServerRequestInterface $req) use ($fn, $that) {
//            todo: may be async
            $res = new Http\Response();
            $ctx = $that->createContext($req, $res);
            return $that->handleRequest($ctx, $fn);
        };
    }

    public function use(callable $fn)
    {
        if (!is_callable($fn)) {
            throw new \TypeError('middleware must be a function!');
        }

        array_push($this->middleware, $fn);
        return $this;
    }

    private function createContext(ServerRequestInterface $req, Http\Response $res): Context
    {
        $context = $this->context;
        $request = $this->request;
        $response = $this->response;

        $context->app = $request->app = $response->app = $this;
        $context->req = $request->req = $response->req = $req;
        $context->res = $response->res = $request->res = $res;
        $request->ctx = $response->ctx = $context;
        $request->response = $response;
        $response->request = $request;

        $context->originalUrl = $request->originalUrl = $req->getUri();
        $request->ctx = $response->ctx = $context;

        return $context;
    }

    private function handleRequest(Context $ctx, callable $fnMiddleware): PromiseInterface
    {
        $res = $ctx->res;
        $res->withStatus(404);

        $onerror = function ($error) use ($ctx) {
            $ctx->onerror()($error);
        };

        $handleResponse = function () use ($ctx) {
            respond($ctx);
        };

        return $fnMiddleware($ctx)->then($handleResponse)->otherwise($onerror);
    }

    private function onerror()
    {
        return function ($error) {
            var_dump('---error-----', $error);
        };
    }


}
<?php


namespace Press;


use Closure;
use Psr\Http\Message\ServerRequestInterface;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\Http;
use React\Http\Server;
use React\Promise\PromiseInterface;
use React\Socket\Server as SocketServer;
use TypeError;
use function Press\Uitls\Respond\respond;
use function Press\Utils\Compose\compose;


class Application extends Utils\Events
{
    public ?Context $context = null;

    public ?Request $request = null;

    public ?Response $response = null;

    private array $middleware = [];

    public ?LoopInterface $loop = null;

    public ?SocketServer $socket = null;

    public bool $proxy = false;

    public string $proxyIpHeader;

    public string $env;

    public int $maxIpCount;

    public int $subdomainOffset;

    public function __construct($options = [])
    {
        $this->proxy = $options['proxy'] ?? false;
        $this->proxyIpHeader = $options['proxyIpHeader'] ?? 'X-Forwarded-For';
        $this->env = $options['env'] ?? 'development';
        $this->maxIpCount = $options['maxIpCount'] ?? 0;
        $this->subdomainOffset = $options['subdomainOffset'] ?? 2;

        $this->context = new Context();
        $this->request = new Request();
        $this->response = new Response();
        $this->loop = Factory::create();
    }

    public function listen($args = [])
    {
        if (!is_array($args)) {
            $fn = $args;
            $args = [];
        } else {
            $fn = null;
        }

        $host = $args['host'] ?? "0.0.0.0";
        $port = $args['port'] ?? 9222;

        $server = new Server($this->loop, $this->callback());
        $socket = new SocketServer("{$host}:{$port}", $this->loop);
        $this->socket = $socket;

        $server->on('error', $this->onerror('Server:Error'));
        $socket->on('error', $this->onerror('Socket:Server:Error'));
        $server->listen($socket);

        if ($fn) {
            $fn();
        }

        $this->loop->run();
    }

    public function callback(): Closure
    {
        $fn = compose($this->middleware);
        $that = $this;

        $this->on('error', $this->onerror());

        return function (ServerRequestInterface $req) use ($fn, $that) {
            $res = new Http\Message\Response();
            $ctx = $that->createContext($req, $res);
            return $that->handleRequest($ctx, $fn);
        };
    }

    public function use(callable $fn): Application
    {
        if (!is_callable($fn)) {
            throw new TypeError('middleware must be a function!');
        }

        array_push($this->middleware, $fn);
        return $this;
    }

    public function createContext(ServerRequestInterface $req, Http\Message\Response $res): Context
    {
        $context = $this->context;
        $request = $this->request;
        $response = $this->response;

        $context->request = $request;
        $context->response = $response;
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

    public function updateReq(ServerRequestInterface $req)
    {
        $context = $this->context;
        $request = $this->request;
        $response = $this->response;

        $context->req = $request->req = $response->req = $req;
    }

    public function updateRes(Http\Message\Response $res)
    {
        $context = $this->context;
        $request = $this->request;
        $response = $this->response;

        $context->res = $response->res = $request->res = $res;
    }

    private function handleRequest(Context $ctx, callable $fnMiddleware): PromiseInterface
    {
        $res = $ctx->res;
        $res->withStatus(404);

        $onerror = function ($error) use ($ctx) {
            return $ctx->onerror()($error);
        };

        $handleResponse = function () use ($ctx) {
            return respond($ctx);
        };

        return $fnMiddleware($ctx)->then($handleResponse)->otherwise($onerror);
    }

    private function onerror($e = ''): Closure
    {
        return function ($error) use ($e) {
            throw $error;
        };
    }


}
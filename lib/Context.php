<?php


namespace Press;


use Press\Utils\Delegates;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use React\Socket\Server;
use stdClass;

/**
 * @property int|null $status
 * @property resource|string|StreamInterface|null $body
 * @property string|null $method
 * @property array|int|mixed|Server|string|null $length
 * @property string|null type
 * @property string|null url
 * @property array|null accepts
 * @method accepts()
 */
class Context
{
    public ?Request $request = null;

    public ?Response $response = null;

    public ?Application $app = null;

    public ?\React\Http\Message\Response $res = null;

    public ?ServerRequestInterface $req = null;

    public string $originalUrl = '';

    public object $state;

    public function __construct()
    {
        $this->state = new stdClass();
    }

    public function __get($name)
    {

        if (isset($this->$name) === false) {
            return null;
        }

        return $this->$name;
    }

    public function __call($name, $args)
    {
        return call_user_func_array($this->$name, $args);
    }

    public function onerror()
    {
        return function ($error) {
            var_dump('---error-----', $error);
        };
    }

    public function delegateRequest()
    {
        $req_delegates = new Delegates($this, 'request');
        $req_delegates->method('acceptsLanguages')
            ->method('acceptsEncodings')
            ->method('acceptsCharsets')
            ->method('accepts')
            ->method('get')
            ->method('is')
            ->access('querystring')
            ->access('idempotent')
            ->access('socket')
            ->access('search')
            ->access('method')
            ->access('query')
            ->access('path')
            ->access('url')
            ->access('accept')
            ->getter('origin')
            ->getter('href')
            ->getter('subdomains')
            ->getter('protocol')
            ->getter('host')
            ->getter('hostname')
            ->getter('URL')
            ->getter('header')
            ->getter('headers')
            ->getter('secure')
            ->getter('stale')
            ->getter('fresh')
            ->getter('ips')
            ->getter('ip');
    }

    public function delegateResponse()
    {
        $res_delegates = new Delegates($this, 'response');
        $res_delegates
            ->method('attachment')
            ->method('redirect')
            ->method('remove')
            ->method('vary')
            ->method('has')
            ->method('set')
            ->method('append')
            ->method('flushHeaders')
            ->access('status')
            ->access('message')
            ->access('body')
            ->access('length')
            ->access('type')
            ->access('lastModified')
            ->access('etag')
            ->getter('headerSent');
    }
}
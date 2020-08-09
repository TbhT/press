<?php


namespace Press;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use React\Promise\Promise;
use stdClass;
use Throwable;

/**
 * @property int|null $status
 * @property resource|string|StreamInterface|null $body
 * @property string|null $method
 * @property int|null $length
 * @property string|null type
 * @property string|null url
 * @property array|null accepts
 * @property bool|null fresh
 * @property string href
 * @property array|string[] headers
 * @property string|null origin
 * @property string|null path
 * @property string[] query
 * @property string|null querystring
 * @property string|null search
 * @property bool|null stale
 * @method accepts(...$args)
 * @method acceptsCharsets(...$args)
 * @method acceptsEncodings(...$args)
 * @method acceptsLanguages(...$args)
 * @method set(...$args)
 * @method get(...$args)
 * @method is(...$args)
 * @method has(string $string)
 * @method remove(string $field)
 * @method vary(...$args)
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
        switch ($name) {
            case 'querystring':
            case 'idempotent':
            case 'socket':
            case 'search':
            case 'method':
            case 'query':
            case 'path':
            case 'url':
            case 'accept':
            case 'origin':
            case 'href':
            case 'subdomains':
            case 'protocol':
            case 'host':
            case 'hostname':
            case 'URL':
            case 'header':
            case 'headers':
            case 'secure':
            case 'stale':
            case 'fresh':
            case 'ips':
            case 'ip':
                return $this->request->$name;
            case 'status':
            case 'message':
            case 'body':
            case 'length':
            case 'type':
            case 'lastModified':
            case 'etag':
            case 'headerSent':
                return $this->response->$name;
            default:
                return null;
        }
    }

    public function __set($name, $value)
    {
        switch ($name) {
            case 'querystring':
            case 'idempotent':
            case 'socket':
            case 'search':
            case 'method':
            case 'query':
            case 'path':
            case 'url':
            case 'accept':
            case 'origin':
            case 'href':
            case 'subdomains':
            case 'protocol':
            case 'host':
            case 'hostname':
            case 'URL':
            case 'header':
            case 'headers':
            case 'secure':
            case 'stale':
            case 'fresh':
            case 'ips':
            case 'ip':
                $this->request->$name = $value;
                break;
            case 'status':
            case 'message':
            case 'body':
            case 'length':
            case 'type':
            case 'lastModified':
            case 'etag':
            case 'headerSent':
                $this->response->$name = $value;
                break;
            default:
                return null;
        }
    }

    public function __call($name, $args)
    {
        if ($name === 'acceptsLanguages') {
            return $this->request->acceptsLanguages(...$args);
        } else if ($name === 'acceptsEncodings') {
            return $this->request->acceptsEncodings(...$args);
        } else if ($name === 'acceptsCharsets') {
            return $this->request->acceptsCharsets(...$args);
        } else if ($name === 'accepts') {
            return $this->request->accepts(...$args);
        } else if ($name === 'get') {
            return $this->request->get(...$args);
        } else if ($name === 'is') {
            return $this->request->is(...$args);
        } else if ($name === 'attachment') {
            $this->response->attachment(...$args);
        } else if ($name === 'redirect') {
            $this->response->redirect(...$args);
        } else if ($name === 'remove') {
            $this->response->remove(...$args);
        } else if ($name === 'vary') {
            $this->response->vary(...$args);
        } else if ($name === 'has') {
            return $this->response->has(...$args);
        } else if ($name === 'set') {
            $this->response->set(...$args);
        } else if ($name === 'append') {
            $this->response->append(...$args);
        } else {
            return call_user_func_array($this->$name, $args);
        }

        return null;
    }

    public function onerror()
    {
        $ctx = $this;
        return function ($error) use ($ctx) {
            return new Promise(function ($resolve, $reject) use ($error, $ctx) {
                try {
                    if (!$error) {
                        return $resolve($ctx->res);
                    }

                    $this->type = 'text';

                    $this->status = 502;

                    $ctx->body = $error;

                    return $resolve($ctx->res);
                } catch (Throwable $e) {
                    return $reject($e);
                }
            });
        };
    }
}
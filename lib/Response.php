<?php


namespace Press;


use Press\Utils\Mime\MimeTypes;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use RingCentral\Psr7\Stream;
use function Press\Utils\Mime\extname;
use function Press\Utils\typeIs;
use function Press\Utils\Vary\vary;
use function RingCentral\Psr7\stream_for;

/**
 * @property int|null status
 * @property string|null type
 * @property int|null length
 * @property array|null header
 * @property bool|null headerSent
 * @property resource|string|StreamInterface body
 * @property string|null etag
 * @property string|null lastModified
 * @property string|null message
 */
class Response
{
    const REDIRECT_STATUS = [
        300 => true,
        301 => true,
        302 => true,
        303 => true,
        305 => true,
        307 => true,
        308 => true,
    ];

    public ?Request $request = null;

    public ?ServerRequestInterface $req = null;

    public ?\React\Http\Message\Response $res = null;

    public ?Application $app = null;

    public ?Context $ctx = null;

    public bool $headersSent = false;

    private $_body = null;

    public function __get($name)
    {
        if ($name === 'socket') {
            return $this->getSocket();
        }

        if ($name === 'headers' || $name === 'header') {
            return $this->getHeaders();
        }

        if ($name === 'status') {
            return $this->getStatus();
        }

        if ($name === 'message') {
            return $this->getMessage();
        }

        if ($name === 'body') {
            return $this->getBody();
        }

        if ($name === 'length') {
            return $this->getLength();
        }

        if ($name === 'type') {
            return $this->getType();
        }

        if ($name === 'lastModified') {
            return $this->getLastModified();
        }

        if ($name === 'etag') {
            return $this->getEtag();
        }

        if (isset($this->$name) === false) {
            return null;
        }

        return $this->$name;
    }

    public function __set($name, $value)
    {
        if ($name === 'status') {
            $this->setStatus($value);
        } else if ($name === 'message') {
            $this->setMessage($value);
        } else if ($name === 'body') {
            $this->setBody($value);
        } else if ($name === 'length') {
            $this->setLength($value);
        } else if ($name === 'type') {
            $this->setType($value);
        } else if ($name === 'lastModified') {
            $this->setLastModified($value);
        } else if ($name === 'etag') {
            $this->setEtag($value);
        } else if (!isset($this->$name)) {
            $this->$name = $value;
        }
    }

    private function getSocket()
    {
        return $this->app->socket;
    }

    private function getHeaders()
    {
        return $this->res->getHeaders();
    }

    private function getStatus()
    {
        return $this->res->getStatusCode();
    }

    private function setStatus(int $code)
    {
        $newRes = $this->res->withStatus($code);
        $this->app->updateRes($newRes);
    }

    private function getMessage()
    {
        return $this->res->getReasonPhrase();
    }

    private function setMessage(string $value)
    {
        $newResponse = $this->res->withStatus($this->status, $value);
        $this->app->updateRes($newResponse);
    }

    private function getBody()
    {
        return $this->_body;
    }

    private function setBody($value)
    {
        $this->_body = $value;

        //  no content
        if ($value === null) {
            $this->remove('Content-Type');
            $this->remove('Content-Length');
            $this->remove('Transfer-Encoding');
            return;
        }

        if (!$this->status) {
            $this->status = 200;
        }

        $hasType = !$this->has('Content-Type');

        if (is_string($value)) {
            if ($hasType) {
                $this->type = preg_match('/^\s*</', $value) ? 'text/html' : 'text/plain';
            }

            $newRes = $this->res->withBody(stream_for($value));
            $this->app->updateRes($newRes);

            $this->length = $this->res->getBody()->getSize();
            return;
        }

        if ($value instanceof Stream) {
            $this->type = 'bin';
            $newRes = $this->res->withBody($value);
            $this->app->updateRes($newRes);
            return;
        }

        $this->remove('Content-Length');
        $this->type = 'application/json';
        $newRes = $this->res->withBody(stream_for(json_encode($value)));
        $this->app->updateRes($newRes);
    }

    private function getLength()
    {
        if ($this->has('Content-Length')) {
            $result = $this->res->getHeader('Content-Length');
            return (int)join('', $result);
        }

        $body = $this->body;

        if ($body instanceof Stream) {
            return $body->getSize();
        }

        if (gettype($body) === 'object') {
            $json = json_encode($body);
            return strlen($json);
        }

        return strlen($body);
    }

    private function setLength(int $n)
    {
        $newRes = $this->res->withHeader('Content-Length', $n);
        $this->app->updateRes($newRes);
    }

    public function remove($filed)
    {
        if ($this->headersSent) {
            return;
        }

        $newRes = $this->res->withoutHeader($filed);
        $this->app->updateRes($newRes);
    }

    public function has(string $field)
    {
        return $this->res->hasHeader(strtolower($field));
    }

    public function vary($field)
    {
        if ($this->headersSent) {
            return;
        }

        vary($this, $field);
    }

    public function redirect(string $url, $alt = null)
    {
//        location
        if ('back' === $url) {
            $url = $this->ctx->get('Referrer');
            $url = $url ?? $alt;
            $url = $url ?? '/';
        }

        $this->set('Location', urlencode($url));

//        status
        if (!isset(static::REDIRECT_STATUS[$this->status])) {
            $this->status = 302;
        }

//        html
        if ($this->ctx->accepts('html')) {
            $url = urlencode($url);
            $this->type = 'text/html; charset=utf-8';
            $this->body = "Redirecting to <a href=\"{$url}\">{$url}</a>.";
            return;
        }

//        text
        $this->type = 'text/plain; charset=utf-8';
        $this->body = "Redirecting to {$url}";
    }

    public function attachment(string $filename, $options)
    {
//        todo
        $this->type = extname($filename);
//        $this->set('Content-Disposition', null);
    }

    private function getType()
    {
        $type = $this->get('Content-Type');
        if (!$type) {
            return '';
        }

        $ar = explode(';', $type);
        return $ar[0];
    }

    private function setType($value = null)
    {
        $value = MimeTypes::contentType($value);
        if ($value) {
            $this->set('Content-Type', $value);
        } else {
            $this->remove('Content-Type');
        }
    }

    private function getLastModified()
    {
        return $this->get('last-modified');
    }

    private function setLastModified($value)
    {
        $this->set('Last-Modified', $value);
    }

    private function getEtag()
    {
        return $this->get('ETag');
    }

    private function setEtag(string $value)
    {
        $flag = preg_match('/^(W\/)?"/', $value, $match);

        if (!$flag) {
            $value = "\"{$value}\"";
        }

        $this->set('ETag', $value);
    }

    public function is(...$args)
    {
        $type = $args[0] ?? null;
        $args = array_slice($args, 1);
        return typeIs($this->type, $type, ...$args);
    }

    public function get(string $field)
    {
        $value = $this->res->getHeader(strtolower($field));
        return join(',', $value);
    }

    public function set(string $field, $value)
    {
        $newRes = $this->res->withHeader(strtolower($field), $value);
        $this->app->updateRes($newRes);
    }

    public function append($field, $value)
    {
        $prev = $this->get($field);
        $this->set($field, [$prev, $value]);
        return $this;
    }
}

<?php


namespace Press;


use Psr\Http\Message\ServerRequestInterface;

/**
 * @property array|int|mixed|\React\Socket\Server|string|null status
 * @property array|int|mixed|\React\Socket\Server|string|null type
 * @property array|int|mixed|\React\Socket\Server|string|null length
 */
class Response
{
    public ?Request $request = null;

    public ?ServerRequestInterface $req = null;

    public ?\React\Http\Response $res = null;

    public ?Application $app = null;

    public ?Context $ctx = null;

    private $body;

    public bool $headersSent = false;

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

        return null;
    }

    public function __set($name, $value)
    {
        if ($name === 'status') {
            $this->setStatus($value);
        }

        if ($name === 'message') {
            $this->setMessage($value);
        }

        if ($name === 'body') {
            $this->setBody($value);
        }

        if ($name === 'length') {
            $this->setLength($value);
        }

        if (!isset($this->$name)) {
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
        $this->res->withStatus($code);
    }

    private function getMessage()
    {
        return $this->res->getReasonPhrase();
    }

    private function setMessage(string $value)
    {
        return $this->res->withStatus($this->status, $value);
    }

    private function getBody()
    {
        return $this->body;
    }

    private function setBody($value)
    {
        $original = $this->body;
        $this->body = $value;

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
            $this->type = preg_match('/^\s*</', $value) ? 'html' : 'text';
            $this->length = $this->res->getBody()->getSize() || 0;
            return;
        }

        $this->remove('Content-Length');
        $this->type = 'json';
    }

    private function getLength()
    {
        return $this->res->getHeader('Content-Length');
    }

    private function setLength(int $n)
    {
        $this->res->withHeader('Content-Length', $n);
    }

    public function remove($filed)
    {
        if ($this->headersSent) {
            return;
        }

        $this->res->withoutHeader($filed);
    }

    public function has(string $field)
    {
        return $this->res->hasHeader($field);
    }

    public function vary()
    {
//        todo:
    }

    public function redirect()
    {
//        todo:
    }

    public function attachment()
    {
//        todo:
    }

    private function getType()
    {
//        todo:
    }

    private function setType()
    {
//        todo:
    }

    private function getLastModified()
    {
//        todo:
    }

    private function setLastModified()
    {
//        todo:
    }

    private function getEtag()
    {
//        todo:
    }

    private function setEtag()
    {
//        todo:
    }

    public function is()
    {
//        todo:
    }

    public function get(string $field)
    {
        return $this->res->getHeader(strtolower($field)) || "";
    }

    public function set(string $field, $value)
    {
        $this->res->withHeader($field, $value);
    }

    public function append()
    {
//        todo:
    }
}

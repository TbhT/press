<?php


namespace Press;


use Psr\Http\Message\ServerRequestInterface;

/**
 * @property array|int|mixed|\React\Socket\Server|string|null status
 */
class Response
{
    public ?Request $request = null;

    public ?ServerRequestInterface $req = null;

    public ?\React\Http\Response $res = null;

    public ?Application $app = null;

    public ?Context $ctx = null;

    private $body;

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

    }

    private function setBody()
    {

    }
}
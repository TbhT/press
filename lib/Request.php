<?php


namespace Press;


use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

class Request
{
    public ?Context $ctx = null;

    public ?Response $response = null;

    public ?ServerRequestInterface $req = null;

    public ?\React\Http\Response $res = null;

    public ?Application $app = null;

    public string $originalUrl = '';

    public function __get($name)
    {
        if ($name === 'header') {
            return $this->getHeader();
        }

        return null;
    }

    public function __set($name, $value)
    {
        if ($name === 'header') {
            $this->setHeader($name, $value);
        }
    }

    private function getHeader()
    {
        return $this->req->getHeaders();
    }

    private function setHeader($name, $value)
    {
        $this->req->withHeader($name, $value);
    }

    private function getUrl()
    {
//        todo: url string whole
    }

    private function setUrl(UriInterface $url)
    {
//        todo: url string whole
    }

    private function getOrigin()
    {
//        todo: protocol . host
    }

    private function getHref()
    {
//        todo: protocol . host . url
    }

    private function getMethod(): string
    {
        return $this->req->getMethod();
    }

    private function setMethod($method)
    {
        $this->req->withMethod($method);
    }

    private function getHost(): string
    {
        $uri = $this->req->getUri();
        return $uri->getHost();
    }

    private function getPath()
    {
        $uri = $this->req->getUri();
        return $uri->getPath();
    }

    private function setPath(string $path)
    {
        $uri = $this->req->getUri();
        $uri->withPath($path);
    }

}
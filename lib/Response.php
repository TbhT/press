<?php


namespace Press;


use Psr\Http\Message\ServerRequestInterface;

class Response
{
    public ?Request $request = null;

    public ?ServerRequestInterface $req = null;

    public ?\React\Http\Response $res = null;

    public ?Application $app = null;

    public ?Context $ctx = null;
}
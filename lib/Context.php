<?php


namespace Press;


use Psr\Http\Message\ServerRequestInterface;
use stdClass;

class Context
{
    public ?Request $request = null;

    public ?Response $response = null;

    public ?Application $app = null;

    public ?\React\Http\Response $res = null;

    public ?ServerRequestInterface $req = null;

    public string $originalUrl = '';

    public object $state;

    public function __construct()
    {
        $this->state = new stdClass();
    }

    public function onerror() {
        return function ($error) {
            var_dump('---error-----', $error);
        };
    }
}
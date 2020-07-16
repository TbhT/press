<?php


namespace Press\Tests\Context;


use Press\Application;
use React\Http\Message\Response;
use RingCentral\Psr7\ServerRequest;

function create()
{
    $req = new ServerRequest('GET', '/');
    $res = new Response();
    $app = new Application();
    return $app->createContext($req, $res);
}

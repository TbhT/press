<?php
declare(strict_types=1);

require_once './vendor/autoload.php';

use Press\Request;
use Press\Response;
use Press\Router\Router;

$req = new Request();
$res = new Response();
$router = new Router();

($router->get)(function () {
    echo '>>>>>>>>>>>>>>>';
});

$router->handle($req, $res, function () {
    echo '===================';
});

echo "----------";


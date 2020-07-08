<?php
declare(strict_types=1);


require_once __DIR__ . '/vendor/autoload.php';

$app = new \Press\Application();

$app->use(function (\Press\Context $ctx,callable $next) {
    var_dump('>>>>>>hello world', $ctx->req->getQueryParams());
    return $next();
});

$app->listen();
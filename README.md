# Press

![PHP Composer](https://github.com/TbhT/press/workflows/PHP%20Composer/badge.svg)
[![codecov](https://codecov.io/gh/TbhT/press/branch/master/graph/badge.svg)](https://codecov.io/gh/TbhT/press)

> This project is a translation of koa framework of nodejs.


## Installation


`$ composer require tbht/press`


## Hello `Press`

```php
use Press\Application;
use Press\Context;

$app = new Application();

$app->use(function (Context $ctx, callable $next) {
    $ctx->body = 'Hello Press';
});

$app->listen();

```

## Middleware

Here is an example of logger middleware :

```php
use Press\Context;

$app->use(function (Context $ctx, callable $next) {
    $start = time();
    return $next()
        ->then(function () use($start, $ctx) {
            $ms = time() - $start;
            $method = $ctx->method;
            $url = $ctx->url;

            print_r("{$method} {$url} - {$ms}ms");        
        });
});

```

### Context, Request and Response

> WIP

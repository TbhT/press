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
use Press\Application;

$app = new Application();

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

## Document

### Application

#### hello world

```php
use Press\Application;
use Press\Context;

$app = new Application();

$app->use(function (Context $ctx, callable $next) { 
      $ctx->body = 'Hello World';
});

$app->listen(function () {
    var_dump('final var dump');
});

// or 

$app->listen(['port' => 8080]);
```

#### Cascading

```php

use Press\Application;
use Press\Context;

$app = new Application();

// logger
$app->use(function (Context $ctx, callable $next) {
    return $next()
        ->then(function () use ($ctx) {
            $rt = $ctx->response->get('x-response-time');
            $method = $ctx->method;
            $url = $ctx->url;
            echo "{$method} {$url} - {$rt}";
        });
});

// x-response-time
$app->use(function (Context $ctx, callable $next) {
    $start = time();
    return $next()
        ->then(function () use ($ctx,$start) {
            $ms = time() - $start;
            $ctx->set('x-response-time', "{$ms}ms");
        });
});

// response
$app->use(function (Context $ctx, callable $next) {
    $ctx->body = 'Hello World';
});
```

#### Settings

- `$app->env` default to the 'development'

- `$app->proxy` when true proxy header fields will be trusted

- `$app->subdomainOffset` offset of `.subdomains` to ignore [2]


#### $app->listen(...)

```php
use Press\Application;

$app = new Application();

$app->listen([
    "host" => "127.0.0.1",
    "port" => 8080
]);

// or 

$app->listen(function () {
    echo "call back run";
});

```


#### $app->callback()

return a callback function suitable for the following http server request.

```php
use React\EventLoop\Factory;

$loop = Factory::create();

$server = new React\Http\Server($loop, function (Psr\Http\Message\ServerRequestInterface $request) {
    
    // ...  

});
```

### $app->use()


# Press

![PHP Composer](https://github.com/TbhT/press/workflows/PHP%20Composer/badge.svg)

> This project is a translation of koa framework of nodejs.

## doc

### Hello `Press`

```php
use Press\Application;
use Press\Context;

$app = new Application();

$app->use(function (Context $ctx, callable $next) {
    $ctx->body = 'Hello Press';
});

$app->listen();

```
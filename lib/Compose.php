<?php


namespace Press\Utils\Compose;

use React\Promise;

function noop()
{
    return function () {

    };
}


function compose(array $middleware): callable
{
    foreach ($middleware as $fn) {
        if (is_callable($fn) === false) {
            throw new \TypeError('Middleware must be composed of functions!');
        }
    }

    // last called middleware
    $index = -1;

    return function ($context, callable $next = null) use (&$middleware, &$index): Promise\PromiseInterface {
        return dispatch($context, $next, $middleware, $index, 0);
    };
}


function dispatch($context, $next, &$middleware, &$index, $start): Promise\PromiseInterface
{
    if ($start <= $index) {
        return Promise\reject(new \Error('$next() called multiple times'));
    }

    $index = $start;

    $fn = $middleware[$start];
    if ($start === count($middleware)) {
        $fn = $next;
    }

    if (!$fn) {
        return Promise\resolve();
    }

    try {
        return Promise\resolve($fn($context, function () use ($start, &$params) {
            $new_params = $params;
            array_push($new_params, $start);
            dispatch(...$new_params);
        }));
    } catch (\Exception $error) {
        return Promise\reject($error);
    }
}
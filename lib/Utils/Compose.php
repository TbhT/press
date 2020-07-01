<?php


namespace Press\Utils;

use React\Promise;


class Compose
{
    public static function compose(array $middleware): callable {
        foreach ($middleware as $fn) {
            if (gettype($fn) !== "function") {
                throw new \TypeError('Middleware must be composed of functions!');
            }
        }

        // last called middleware
        $index = -1;

        return function ($context, callable $next) use (&$middleware, &$index) {
            Compose::dispatch($context, $next, $middleware, $index, 0);
        };
    }

    private static function dispatch(&...$params): Promise\PromiseInterface {
        [$context, $next, $middleware, &$index, $start] = $params;

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
                Compose::dispatch(...$new_params);
            }));
        } catch (\Exception $error) {
            return Promise\reject($error);
        }
    }
}
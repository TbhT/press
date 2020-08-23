<?php


namespace Press\Utils\Co;

use Exception;
use Generator;
use Press\Context;
use React\Promise\Promise;
use React\Promise\PromiseInterface;
use ReflectionFunction;
use function React\Promise\resolve as PromiseResolve;


function onFulfilled($resolve, $reject, Generator $gen, $args = [])
{
    return function ($result = null) use ($args, $resolve, $reject, $gen) {
        try {
            $gen->send($result);
            return coNext($gen, $resolve, $reject);
        } catch (Exception $exception) {
            return $reject($exception);
        }
    };
}


function onRejected($resolve, $reject, Generator $gen)
{
    return function ($error = null) use ($resolve, $reject, $gen) {
        try {
            $gen->throw($error);
            return coNext($gen, $resolve, $reject);
        } catch (Exception $exception) {
            return $reject($exception);
        }
    };
}


function coNext(Generator $ret, callable $resolve, callable $reject)
{
    if ($ret->valid() === false) {
        return $resolve($ret->current());
    }

    $value = toPromise($ret->current());

    if ($value && $value instanceof PromiseInterface) {
        return $value->then(onFulfilled($resolve, $reject, $ret), onRejected($resolve, $reject, $ret));
    }

    return onRejected($resolve, $reject, $ret)(new \TypeError('You may only yield a function, promise, generator'
        . 'but the following object was passed: "' . "{$ret}" . '"'));
}


function co(...$args): PromiseInterface
{
    $gen = $args[0];
    $args = array_slice($args, 1);

    return new Promise(function (callable $resolve, callable $reject) use ($gen, $args) {
        if (is_callable($gen) && isGeneratorFunction($gen)) {
            $gen = $gen(...$args);
        }

        coNext($gen, $resolve, $reject);
    });
}


function isGeneratorFunction($fn)
{
    try {
        $reflection = new ReflectionFunction($fn);
        return $reflection->isGenerator();
    } catch (\ReflectionException $e) {
        return false;
    }
}


function toPromise($obj): PromiseInterface
{
    if ($obj instanceof Promise) {
        return $obj;
    }

    if (isGeneratorFunction($obj) || $obj instanceof Generator) {
        return co($obj);
    }

    return PromiseResolve($obj);
}

function convert(callable $mw)
{
    return function (Context $ctx, callable $next) use ($mw) {
        return co($mw);
    };
}
<?php


namespace Press\Utils\Co;

use Exception;
use Generator;
use React\Promise\Promise;
use React\Promise\PromiseInterface;
use ReflectionFunction;
use function React\Promise\resolve as PromiseResolve;


function onFulfilled($resolve, $reject, $gen, $args = [])
{
    return function ($res = null) use ($args, $resolve, $reject, $gen) {
        try {
            if (is_callable($gen)) {
                $gen = $gen(...$args);
            } else {
                $gen->send($res);
            }

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
        onFulfilled($resolve, $reject, $gen, $args)();
    });
}


function isGeneratorFunction($obj)
{
    try {
        $reflection = new ReflectionFunction($obj);
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
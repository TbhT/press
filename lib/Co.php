<?php


namespace Press\Utils\Co;


use Exception;
use Generator;
use phpDocumentor\Reflection\Types\Mixed_;
use React\Promise\Promise;
use React\Promise\PromiseInterface;
use Reflection;
use ReflectionFunction;
use function React\Promise\reject;
use function React\Promise\resolve;


function onFulfilled($resolve, $reject)
{
    return function ($res, Generator $gen) use ($resolve, $reject) {
        try {
            $ret = $gen->send($res);
            return coNext($ret, $resolve, $reject);
        } catch (Exception $exception) {
            return $reject($exception);
        }
    };
}


function onRejected($resolve, $reject)
{
    return function ($error, Generator $gen) use ($resolve, $reject) {
        try {
            $ret = $gen->throw($error);
            return coNext($ret, $resolve, $reject);
        } catch (Exception $exception) {
            return $reject($exception);
        }
    };
}


function coNext($ret, callable $resolve, callable $reject)
{
    if ($ret->valid() === false) {
        return $resolve($ret->current());
    }

    $value = toPromise($ret->current());

    if ($value && $value instanceof Promise) {
        return $value->then(onFulfilled($resolve, $reject), onRejected($resolve, $reject));
    }

    return onRejected($resolve, $reject)(new \TypeError('You may only yield a function, promise, generator'
        . 'but the following object was passed: "' . "{$ret}" . '"'));
}


function co(...$args): PromiseInterface
{
    $gen = $args[0];
    $args = array_slice($args, 1);

    return new Promise(function (callable $resolve, callable $reject) use ($gen, $args) {
        if (is_callable($gen)) {
            $gen = $gen(...$args);
        }

        onFulfilled($resolve, $reject);
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

    return $obj;
}
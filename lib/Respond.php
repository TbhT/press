<?php

namespace Press\Uitls\Respond;


use Press\Context;
use React\Http\Response;
use React\Promise\Promise;
use React\Promise\PromiseInterface;

function respond(Context $ctx): PromiseInterface
{
    return new Promise(function ($resolve, $reject) use ($ctx) {
        try {
            $res = $ctx->res;

            $body = $ctx->body;
            $code = $ctx->status;

            if (!$code) {
                $ctx->response->headerSent = true;
                return $resolve($res);
            }

            return $resolve($res);
        } catch (\Exception $error) {
            return $reject($error);
        }
    });
}
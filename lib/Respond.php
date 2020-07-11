<?php

namespace Press\Uitls\Respond;


use Press\Context;
use React\Promise\Promise;
use React\Promise\PromiseInterface;
use function RingCentral\Psr7\stream_for;

function respond(Context $ctx): PromiseInterface
{
    return new Promise(function ($resolve, $reject) use ($ctx) {
        try {
            $res = $ctx->res;
            $body = $ctx->body ?? '';
            $code = $ctx->status;

            if (!$code) {
                $ctx->response->headerSent = true;
                return $resolve($res);
            }

            if ('HEAD' === $ctx->method) {
                if (!$ctx->response->headersSent && !$ctx->response->has('Content-Length')) {
                    $ctx->length = $ctx->response->length;
                }

                return $resolve($res);
            }

            if (!$body) {
                $body = (string)$code;
                if (!$ctx->response->headerSent) {
                    $ctx->type = 'text';
                    $ctx->length = strlen($body);
                }
            }

            if ($body) {
                $res = $res->withBody(stream_for($body));
            }

            return $resolve($res);
        } catch (\Exception $error) {
            return $reject($error);
        }
    });
}
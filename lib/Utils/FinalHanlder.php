<?php

namespace Press\Utils;


use Press\Request;
use Press\Response;
use Swoole\Timer;

class FinalHanlder
{
    public static function create_html_document(string $message)
    {
        $message = htmlspecialchars($message);
        preg_replace('/\n/', '<br>', $message);
        preg_replace('/\x20{2}/', ' &nbsp;', $message);

        return <<<TAG
        <!DOCTYPE html>\n
        <html lang="en">\n
        <head>\n
        <meta charset="utf-8">\n
        <title>Error</title>\n
        </head>\n
        <body>\n
        <pre>' + {$message} + '</pre>\n'
        </body>\n
        </html>\n
        TAG;
    }

    public static function final_handler(Request $req, Response $res, array $options = [])
    {
        $env = array_key_exists('env', $options) ? $options['env'] : 'development';
        $onError = $options['onerror'];

        return function ($error) use ($req, $res, &$options, $onError) {
            if (!$error && $res->headers) {
                return;
            }

            //unhandled error
            if ($error) {
                // respect status code from error
                $status = $error->getCode();

                $statusCode = $res->statusCode;
                $statusCode = !$statusCode ? 500 : $statusCode;

                $msg = $error->getMessage();
            } else {
                $status = 404;
                $url = urlencode($req->headers['pathname']);
                $msg = "can not {$req->method} ";
            }

            if ($error && $onError) {
                Timer::after(1, function () use ($onError, $error, $req, $res) {
                    $onError($req, $res, $error);
                });
            }
        };
    }
}
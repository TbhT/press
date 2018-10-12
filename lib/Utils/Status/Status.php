<?php

namespace Press\Utils\Status;

use function PHPSTORM_META\type;
use Press\Utils\Status\Code;


class Status
{
    public static function status($code)
    {
        if (!is_string($code) && !is_int($code)) {
            throw new \Error("code must by a number or a string");
        }

        $code = (string)$code;
        if (!array_key_exists($code, Code::CODE)) {
            throw new \Error("invalid status code {$code}");
        }

        return Code::CODE[$code];
    }
}
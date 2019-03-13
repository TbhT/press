<?php

declare(strict_types=1);

namespace Press\Helper;


class FunctionHelper
{
    static public function getParamsNum()
    {

    }

    static public function extname(string $str)
    {
        preg_match('/(^\.\w+$)|([\-\w\d.:\/\\\\]+)/', $str, $matches);
        $matches_length = count($matches);
        var_dump($matches);

        if ($matches_length === 2) {
    //    for extension
            $extname = substr($str, 1);
        } else if ($matches_length === 3) {
    //    for path
            $file_info = pathinfo($matches[2]);
            $extname = array_key_exists('extension', $file_info) ?
                $file_info['filename'] === '' ? '' : $file_info['extension'] : '';
        } else {
            $extname = '';
        }

        return $extname;
    }

}

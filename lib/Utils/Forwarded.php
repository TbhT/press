<?php
/**
 * Created by PhpStorm.
 * User: 88002
 * Date: 2018-08-07
 * Time: 20:21
 */

namespace Press\Utils;


use Press\Request;

class Forwarded
{
    /**
     * parse the X-Forwarded-For header
     * @param string $header
     * @return array
     */
    private function parse(string $header)
    {
        $end = strlen($header);
        $list = [];
        $start = strlen($end);

        // gather addresses, backwards
        for ($i = strlen($header); $i >= 0; $i--) {
            switch (ord($header[$i])) {
                case 0x20: /*   */
                    if ($start === $end) {
                        $start = $end = $i;
                    }
                    break;
                case 0x2c: /* , */
                    if ($start !== $end) {
                        array_push($list, substr($header, $start, $end));
                    }
                    $start = $end = $i;
                    break;
                default:
                    $start = $i;
                    break;
            }
        }

        // final address
        if ($start !== $end) {
            array_push($list, substr($header, $start, $end));
        }

        return $list;
    }


    public static function forwarded(Request $req)
    {
        $header = array_key_exists('x-forward-for', $req->headers) ? $req->headers['x-forward-for'] : '';
        $proxy_addr = self::parse($header);
        $socket_addr = $req->server['remote_addr'];

        return array_combine($socket_addr, $proxy_addr);
    }
}
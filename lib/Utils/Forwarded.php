<?php
declare(strict_types=1);

namespace Press\Utils;


use Swoole\Http\Request;

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
        $start = strlen($header);

        // gather addresses, backwards
        for ($i = strlen($header) - 1; $i >= 0; $i--) {
            switch (ord($header[$i])) {
                case 0x20: /*   */
                    if ($start === $end) {
                        $start = $end = $i;
                    }
                    break;
                case 0x2c: /* , */
                    if ($start !== $end) {
                        array_push($list, substr($header, $start, $end - $start));
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
        $header = array_key_exists('x-forwarded-for', $req->header) ? $req->header['x-forwarded-for'] : '';
        $header = empty($header) ? '' : $header;
        $proxy_addr = self::parse($header);
        $socket_addr = array_key_exists('remote_addr', $req->server) ? $req->server['remote_addr'] : '';

        return array_merge([$socket_addr], $proxy_addr);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-7-7
 * Time: 上午8:53
 */

use Press\Utils\Accepts;
use Press\Request;
use PHPUnit\Framework\TestCase;


class AcceptsTest extends TestCase
{
    private static function createRequest(string $str)
    {
        $req = new Request();
        $req->headers = [
            'accept-charset' => $str
        ];

        return $req;
    }

    public function testCharsetWithNoArguments()
    {
        {
            $req = self::createRequest('utf-8, iso-8859-1;q=0.2, utf-7;q=0.5');
            $accept = new Accepts($req);
            $charsets = $accept->charsets();
            self::assertEquals($charsets, ['utf-8', 'utf-7', 'iso-8859-1']);
        };
        {

        }
    }
}

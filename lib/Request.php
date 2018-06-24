<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-24
 * Time: 上午7:32
 */

namespace Press;

use Swoole\Http\Request as SRequest;


class Request extends SRequest
{
    public $headers;

    public function __construct()
    {
        $this->headers = $this->header;
    }

    private function get_head(string $name)
    {
        if (empty($name)) {
            throw new \TypeError('name argument is required to $req->get');
        }

        $lc = strtolower($name);

        switch ($lc) {
            case 'referer':
            case 'referrer':
                return $this->headers['referer'] || $this->headers['referrer'];
            default:
                return $this->headers[$lc];
        }
    }


    public function header(string $name)
    {
        return $this->get_head($name);
    }


    public function get(string $name)
    {
        return $this->get_head($name);
    }


    public function accepts()
    {

    }

}
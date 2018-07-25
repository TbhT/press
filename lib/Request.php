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
use Press\Utils\Accepts;
use Press\Utils\TypeIs;


class Request extends SRequest
{
    public $headers;

    public function __construct()
    {
        $this->headers = $this->header;
    }

    /**
     * @param string $name
     * @return bool
     */
    private function get_head(string $name)
    {
        if (empty($name)) {
            throw new \TypeError('name argument is required to $req->get');
        }

        $lc = strtolower($name);

        switch ($lc) {
            case 'referer':
            case 'referrer':
                $er = array_key_exists('referer', $this->headers);
                $rer = array_key_exists('referrer', $this->headers);
                $result = $er ? $this->headers['referer'] : $rer ? $this->headers['referer'] : null;
                return $result;
            default:
                return array_key_exists($lc, $this->headers) ? $this->headers[$lc] : null;
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
        $accepts = new Accepts($this);
        return $accepts->types();
    }

}
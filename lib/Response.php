<?php
declare(strict_types=1);

namespace Press;
use Swoole\Http\Response as SResponse;


class Response extends SResponse
{
    public $headers;
    private $statusCode;

    public function __construct()
    {
        $this->headers = $this->header;
    }

    /**
     * @param $field
     * @return mixed
     */
    public function get($field)
    {
        return $this->headers[$field];
    }

    /**
     * 设置HttpCode，如404, 501, 200
     * @param $code
     */
    public function status($code)
    {
        parent::status($code);
        $this->statusCode = $code;
    }

    public function cookie($key, $value, array $option = [])
    {
        $expire = array_key_exists('expire', $option) ? $option['expire'] : Date;
//        parent::cookie($key, $value, $expire, $path, $domain, $secure, $httponly); // TODO: Change the autogenerated stub
    }

    public function clear_cookie()
    {

    }

    public function header($key, $value)
    {
        parent::header($key, $value); // TODO: Change the autogenerated stub
    }

    public function set($key, $value)
    {
        $this->header($key, $value);
    }

    public function location()
    {

    }

    public function redirect()
    {

    }

    public function vary()
    {

    }

    public function render()
    {

    }
}
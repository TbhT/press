<?php
declare(strict_types=1);

namespace Press;

use Swoole\Http\Response as SResponse;


class Response extends SResponse
{
    public $headers;
    private $status_code;

    public function __construct()
    {
        $this->headers = $this->header;
    }

    /**
     * set http header info
     * @param $key
     * @param $value
     * @return Response
     */
    public function header($key, $value)
    {
        parent::header($key, $value);
        return $this;
    }

    /**
     * @param $field
     * @return mixed
     */
    public function get($field)
    {
        return array_key_exists($field, $this->headers) ? $this->headers[$field] : null;
    }

    /**
     * @param $key
     * @param $value
     * @return Response
     */
    public function set($key, $value)
    {
        $this->header($key, $value);
        return $this;
    }

    /**
     * set http status code
     * @param $code
     */
    public function status($code)
    {
        parent::status($code);
        $this->status_code = $code;
    }

    /**
     * @param array $links
     * @return Response
     */
    public function links(array $links)
    {
        $link = $this->get('Link');
        $link = !empty($link) ? $link . ', ' : '';
        $link_result = '';

        foreach ($links as $rel => $link) {
            $link_result .= "<{$link}>; rel=\"{$rel}\", ";
        }

        $link_result = $link . $link_result;

        return $this->set('Link', $link_result);
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
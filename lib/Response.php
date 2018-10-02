<?php
declare(strict_types=1);

namespace Press;

use Press\Utils\Mime\MimeTypes;
use Swoole\Http\Response as SResponse;


class Response extends SResponse
{
    public $headers;
    private $status_code;
    private $req;
    private $app;

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

    /**
     * @param string $type
     * @return Response
     */
    public function type(string $type)
    {
        $ct = MimeTypes::lookup($type);
        return $this->set('Content-Type', $ct);
    }

    /**
     * alias for type() method
     * @param string $type
     * @return Response
     */
    public function contentType(string $type)
    {
        return $this->type($type);
    }



    public function send($body)
    {
        //settings
        $app = $this->app;

        switch (gettype($body)) {
            case 'string':
                if (!$this->type($body)) {
                    $this->type('html');
                }
                break;
            case 'array':
                return $this->json($body);
        }

        //


    }

    public function json()
    {

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
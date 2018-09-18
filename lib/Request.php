<?php
declare(strict_types=1);

namespace Press;


use Press\Utils\RangeParser;
use Swoole\Http\Request as SRequest;
use Press\Utils\Accepts;
use Press\Utils\TypeIs;
use Press\Utils\Fresh;
use Press\Utils\ProxyAddr;


class Request extends SRequest
{
    public $headers;
    public $params = [];
    public $query = [];
    public $body = [];
    private $property_array = [
        'protocol', 'secure', 'ip', 'ips', 'subdomains', 'path',
        'hostname', 'fresh', 'stale', 'xhr'
    ];
    private $protocol;
    private $secure;
    private $path;
    private $host;

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
        $args = func_get_args();
        $accepts = new Accepts($this);
        return $accepts->types($args);
    }

    public function accepts_encodings()
    {
        $args = func_get_args();
        $accepts = new Accepts($this);
        return $accepts->encodings($args);
    }

    public function accepts_charsets()
    {
        $args = func_get_args();
        $accepts = new Accepts($this);
        return $accepts->charsets($args);
    }

    public function accepts_languages()
    {
        $args = func_get_args();
        $accepts = new Accepts($this);
        return $accepts->languages($args);
    }

    public function range($size, $options)
    {
        $range = $this->get('Range');
        if ($range) {
            return RangeParser::rangeParser($size, $range, $options);
        }
    }


    public function param($name, $default_value)
    {
        $params = $this->params;
        $body = $this->body;
        $query = $this->query;

        if (array_key_exists($name, $params)) {
            return $params[$name];
        }

        if (array_key_exists($name, $body)) {
            return $body[$name];
        }

        if (array_key_exists($name, $query)) {
            return $query[$name];
        }

        return $default_value;
    }

    public function is($types)
    {
        if (is_array($types) === false) {
            $types = func_get_args();
        }

        return TypeIs::typeOfRequest($this, $types);
    }

    public function __get($name)
    {
        $pos = array_search($this->property_array, $name);

        if ($pos !== false) {
            return $this->$name;
        } else {
            throw new \TypeError("Request has no property {$name}");
        }
    }

    private function set_protocol()
    {
        $server_protocol = $this->server['server_protocol'];
        $sp_array = explode('/', $server_protocol);

        $this->protocol = strtolower($sp_array[0]) === 'https' ? 'https' : 'http';
    }

    private function set_secure()
    {
        $this->secure = $this->protocol === 'https';
    }

    private function set_ip()
    {

    }

    private function set_path()
    {
        $this->path = $this->server['path_info'];
    }

    private function set_host()
    {
        $this->host = $this->headers['host'];
    }

    private function set_fresh()
    {
        $method = $this->server['request_method'];

        if ($method !== 'GET' &&  $method !== 'HEAD') {
            return false;
        }

        
    }

}
<?php
declare(strict_types=1);

namespace Press;


use Press\Utils\RangeParser;
use Swoole\Http\Request as SRequest;
use Press\Utils\Accepts;
use Press\Utils\TypeIs;
use Press\Utils\Fresh;
use Press\Utils\ProxyAddr;


/**
 * Class Request
 * @property Response res
 * @property callable next
 * @package Press
 */
class Request extends SRequest
{
    public $headers;
    public $params = [];
    public $query = [];
    public $body = [];
    public $app = null;
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

    /**
     * return Request header
     *
     * @param string $name
     * @return bool
     */
    public function header(string $name)
    {
        return $this->get_head($name);
    }


    /**
     * alias for header()
     * @param string $name
     * @return bool
     */
    public function get(string $name)
    {
        return $this->get_head($name);
    }

    /**
     * check if the given type(s) is acceptable
     * @return array|bool|mixed
     */
    public function accepts()
    {
        $args = func_get_args();
        $accepts = new Accepts($this);
        return $accepts->types($args);
    }

    /**
     * Check if the given `encoding`s are accepted
     * @return array|bool
     */
    public function accepts_encodings()
    {
        $args = func_get_args();
        $accepts = new Accepts($this);
        return $accepts->encodings($args);
    }

    /**
     * Check if the given `charset`s are acceptable
     * @return array|bool
     */
    public function accepts_charsets()
    {
        $args = func_get_args();
        $accepts = new Accepts($this);
        return $accepts->charsets($args);
    }

    /**
     * Check if the given `lang`s are acceptable
     * @return array|bool
     */
    public function accepts_languages()
    {
        $args = func_get_args();
        $accepts = new Accepts($this);
        return $accepts->languages($args);
    }

    /**
     * Parse Range header field, capping to the given `size`
     * @param $size
     * @param $options
     * @return array|int
     */
    public function range($size, $options)
    {
        $range = $this->get('Range');
        if ($range) {
            return RangeParser::rangeParser($size, $range, $options);
        }
    }


    /**
     * Return the value of param `name` when present or `defaultValue`
     * @param $name
     * @param $default_value
     * @return mixed
     */
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

    /**
     * Check if the incoming request contains the "Content-Type"
     * header field, and it contains the give mime `type`
     * @param $types
     * @return null
     */
    public function is($types)
    {
        // support flatten arguments
        if (is_array($types) === false) {
            $types = func_get_args();
        }

        return TypeIs::typeOfRequest($this, $types);
    }

    /**
     * for @property_array
     * @param $name
     * @return mixed
     */
    public function __get($name)
    {
        $pos = array_search($this->property_array, $name);

        if ($pos !== false) {
            $val = null;
            switch ($name) {
                case 'protocol':
                    $val = $this->get_protocol();
                    break;
                case 'secure':
                    $val = $this->get_secure();
                    break;
                case 'ip':
                    $val = $this->get_ip();
                    break;
                case 'ips':
                    $val = $this->get_ips();
                    break;
                case 'subdomains':
                    $val = $this->get_subdomains();
                    break;
                case 'path':
                    $val = $this->get_path();
                    break;
                case 'hostname':
                case 'host':
                    $val = $this->get_hostname();
                    break;
                case 'fresh':
                    $val = $this->get_fresh();
                    break;
                case 'stale':
                    $val = $this->get_stale();
                    break;
                case 'xhr':
                    $val = $this->get_xhr();
                    break;
            }

            return $val;
        }
    }

    /**
     * set the protocol property
     */
    private function get_protocol()
    {
        $server_protocol = $this->server['server_protocol'];
        $sp_array = explode('/', $server_protocol);

        $this->protocol = strtolower($sp_array[0]) === 'https' ? 'https' : 'http';
    }

    /**
     * set the secure property
     */
    private function get_secure()
    {
        $this->secure = $this->protocol === 'https';
    }

    /**
     * set the ip property
     */
    private function get_ip()
    {
        $trust = $this->app->get('trust proxy fn');
        return ProxyAddr::proxyaddr($this, $trust);
    }

    /**
     * @return mixed
     */
    private function get_ips()
    {
        $trust = $this->app->get('trust proxy fn');

        $addrs = ProxyAddr::all($this, $trust);
        return array_pop(array_reverse($addrs));
    }

    /**
     * @return array
     */
    private function get_subdomains()
    {
        if (!array_key_exists('host', $this->headers)) {
            return [];
        }

        $offset = $this->app->get('subdomain offset');
        $host = $this->headers['host'];

        $subdomains = !filter_var($host, FILTER_VALIDATE_IP) ?
            array_reverse(explode('.', $host)) : [$host];

        return array_slice($subdomains, $offset);
    }

    /**
     *
     */
    private function get_path()
    {
        if (array_key_exists('path_info', $this->server)) {
            return $this->server['path_info'];
        }

        return null;
    }

    private function get_hostname()
    {
        $host = $this->get('X-Forwarded-Host');
        $trust = $this->app->get('trust proxy fn');

        if (!$host || !$trust($this->server['remote_addr'], 0)) {
            $host = $this->get('Host');
        }

        if (!$host) {
            return;
        }
    }

    /**
     * @return bool
     */
    private function get_fresh()
    {
        $method = $this->server['request_method'];
        $res = $this->res;
        $status = http_response_code();

        if ($method !== 'GET' && $method !== 'HEAD') {
            return false;
        }

        if (($status >= 200 && $status < 300) || 304 === $status) {
            return Fresh::fresh($this->headers, [
                'etag' => $res->get('ETag'),
                'last-modified' => $res->get('Last-Modified')
            ]);
        }

        return false;
    }

    /**
     * @return bool
     */
    private function get_stale()
    {
        return !$this->get_fresh();
    }

    /**
     * @return bool
     */
    private function get_xhr()
    {
        $val = $this->get('X-Requested-With');
        $val = $val === null ? '' : $val;

        return strtolower($val) === 'xmlhttprequest';
    }
}
<?php
declare(strict_types=1);

namespace Press;


use Press\Utils\RangeParser;
use Press\Utils\Accepts;
use Press\Utils\TypeIs;
use Press\Utils\Fresh;
use Press\Utils\ProxyAddr;


/**
 * Class Request
 * @property Response res
 * @property callable next
 * @property Press app
 * @property \Swoole\Http\Request req
 * @property string protocol
 * @property bool secure
 * @property mixed ip
 * @property mixed ips
 * @property array subdomains
 * @property null path
 * @property string hostname
 * @property string host
 * @property bool fresh
 * @property bool stale
 * @property bool xhr
 * @package Press
 */
class Request
{
    public $params = [];
    public $query = [];
    public $body = [];

    /**
     * Request constructor.
     * @param \Swoole\Http\Request $req
     */
    public function __construct(\Swoole\Http\Request $req)
    {
        $this->req = $req;
        $this->req->header = empty($req->header) ? [] : $req->header;
        $this->req->server = empty($req->server) ? [] : $req->server;
    }

    /**
     * @return \Closure
     */
    public function init_properties()
    {
        return function () {
            $this->get_protocol();
            $this->get_secure();
            $this->get_ip();
            $this->get_ips();
            $this->get_subdomains();
            $this->get_path();
            $this->get_hostname();
            $this->get_fresh();
            $this->get_stale();
            $this->get_xhr();
        };
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
        $header = $this->req->header;

        switch ($lc) {
            case 'referer':
            case 'referrer':
                $er = array_key_exists('referer', $header);
                $rer = array_key_exists('referrer', $header);
                $result = $er ? $header['referer'] : $rer ? $header['referer'] : null;
                return $result;
            default:
                return array_key_exists($lc, $header) ? $header[$lc] : null;
        }
    }

    /**
     * return Request header
     *
     * @return \Closure
     */
    public function header()
    {
        return function (string $name) {
            return $this->get_head($name);
        };
    }


    /**
     * alias for header()
     * @return \Closure
     */
    public function get()
    {
        return function (string $name) {
            return $this->get_head($name);
        };
    }

    /**
     * check if the given type(s) is acceptable
     * @return \Closure
     */
    public function accepts()
    {
        return function () {
            $args = func_get_args();
            $accepts = new Accepts($this->req);
            return $accepts->types($args);
        };
    }

    /**
     * Check if the given `encoding`s are accepted
     * @return \Closure
     */
    public function accepts_encodings()
    {
        return function () {
            $args = func_get_args();
            $accepts = new Accepts($this->req);
            return $accepts->encodings($args);
        };
    }

    /**
     * Check if the given `charset`s are acceptable
     * @return \Closure
     */
    public function accepts_charsets()
    {
        return function () {
            $args = func_get_args();
            $accepts = new Accepts($this->req);
            return $accepts->charsets($args);
        };
    }

    /**
     * Check if the given `lang`s are acceptable
     * @return \Closure
     */
    public function accepts_languages()
    {
        return function () {
            $args = func_get_args();
            $accepts = new Accepts($this->req);
            return $accepts->languages($args);
        };
    }

    /**
     * Parse Range header field, capping to the given `size`
     * @return \Closure
     */
    public function range()
    {
        return function ($size, $options) {
            $range = ($this->req->get)('Range');
            if ($range) {
                return RangeParser::rangeParser($size, $range, $options);
            }
        };
    }


    /**
     * Return the value of param `name` when present or `defaultValue`
     * @return \Closure
     */
    public function param()
    {
        return function ($name, $default_value) {
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
        };
    }

    /**
     * Check if the incoming request contains the "Content-Type"
     * header field, and it contains the give mime `type`
     * @return \Closure
     */
    public function is()
    {
        return function ($types) {
            // support flatten arguments
            if (is_array($types) === false) {
                $types = func_get_args();
            }

            return TypeIs::typeOfRequest($this->req, $types);
        };
    }

    private function get_protocol()
    {
        $server_protocol = empty($this->req->server) ? '' :
            array_key_exists('server_protocol', $this->req->server) ?
                $this->req->server['server_protocol'] : '';

        $sp_array = explode('/', $server_protocol);
        $this->req->protocol = strtolower($sp_array[0]) === 'https' ? 'https' : 'http';
    }

    private function get_secure()
    {
        $this->req->secure = $this->req->protocol === 'https';
    }

    private function get_ip()
    {
        $trust = $this->req->app->get('trust proxy fn');
        $this->req->ip = ProxyAddr::proxyaddr($this->req, $trust);
    }

    private function get_ips()
    {
        $trust = $this->req->app->get('trust proxy fn');
        $addrs = ProxyAddr::all($this->req, $trust);
        $addrs = array_reverse($addrs);
        $this->req->ips = array_pop($addrs);
    }

    private function get_subdomains()
    {
        if (!array_key_exists('host', $this->req->header)) {
            return $this->req->subdomains = [];
        }

        $offset = $this->req->app->get('subdomain offset');
        $host = $this->req->header['host'];

        $subdomains = !filter_var($host, FILTER_VALIDATE_IP) ?
            array_reverse(explode('.', $host)) : [$host];

        $this->req->subdomains = array_slice($subdomains, $offset);
    }

    private function get_path()
    {
        if (array_key_exists('path_info', $this->req->server)) {
            $this->req->path = $this->req->server['path_info'];
        } else {
            $this->req->path = '';
        }
    }

    private function get_hostname()
    {
        $host = ($this->req->get)('X-Forwarded-Host');
        $trust = $this->req->app->get('trust proxy fn');

        if (!$host || !$trust($this->req->server['remote_addr'], 0)) {
            $this->req->hostname = ($this->req->get)('Host');
        } else {
            $this->req->hostname = '';
        }
    }

    private function get_fresh()
    {
        if (empty($this->req->server)) {
            return $this->req->fresh = false;
        }
        $method = $this->req->server['request_method'];
        $res = $this->res;
        $status = http_response_code();

        if ($method !== 'GET' && $method !== 'HEAD') {
            $this->req->fresh = false;
        }

        if (($status >= 200 && $status < 300) || 304 === $status) {
            $this->req->fresh = Fresh::fresh($this->req->header, [
                'etag' => $res->get('ETag'),
                'last-modified' => $res->get('Last-Modified')
            ]);
        }

        $this->req->fresh = false;
    }

    private function get_stale()
    {
        $this->req->stale = !$this->req->fresh;
    }

    private function get_xhr()
    {
        $val = ($this->req->get)('X-Requested-With');
        $val = $val === null ? '' : $val;

        $this->req->xhr = strtolower($val) === 'xmlhttprequest';
    }
}
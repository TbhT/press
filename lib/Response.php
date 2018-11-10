<?php
declare(strict_types=1);

namespace Press;

use Press\Utils\ContentType;
use Press\Utils\Mime\MimeTypes;
use Press\Utils\Status;
use Press\Utils\Vary;


const CHARSET_REGEXP = '/;\s*charset\s*=/';


/**
 * @param $type
 * @param $charset
 * @return mixed|string
 */
function set_charset($type, $charset)
{
    if (!$type || !$charset) {
        return $type;
    }

    // parse type
    $parsed = ContentType::parse($type);

    // set charset
    $parsed['parameters']['charset'] = $charset;

    // format type
    return ContentType::format($parsed);
}


/**
 * Class Response
 * @property Request req
 * @property Application app
 * @package Press
 */
class Response
{
    private $status_code;
    private $headers;
    private $res;

    public function __construct(\Swoole\Http\Response $res)
    {
        $this->res = $res;
    }

    /**
     * @return \Closure
     */
    public function get()
    {
        return function ($field) {
            return array_key_exists($field, $this->res->header) ? $this->res->header[$field] : null;
        };
    }

    /**
     * @return \Closure
     */
    public function set()
    {
        return function ($key, $value) {
            $this->res->header($key, $value);
            return $this;
        };
    }

    /**
     * set http status code
     * @return \Closure
     */
    public function status_code()
    {
        return function ($code) {
            $this->res->status($code);
            $this->status_code = $code;
            return $this;
        };
    }

    /**
     * @return \Closure
     */
    public function links()
    {
        return function (array $links) {
            $link = $this->res->get('Link');
            $link = !empty($link) ? $link . ', ' : '';
            $link_result = '';

            foreach ($links as $rel => $link) {
                $link_result .= "<{$link}>; rel=\"{$rel}\", ";
            }

            $link_result = $link . $link_result;

            return $this->res->set('Link', $link_result);
        };
    }

    /**
     * @return \Closure
     */
    public function type()
    {
        return function (string $type) {
            $ct = MimeTypes::lookup($type);
            return $this->res->set('Content-Type', $ct);
        };
    }

    /**
     * alias for type() method
     * @return \Closure
     */
    public function content_type()
    {
        return function (string $type) {
            return $this->res->type($type);
        };
    }


    /**
     * @return \Closure
     */
    public function send()
    {
        return function ($body = '') {
            //settings
            $app = $this->app;
            $req = $this->req;

            switch (gettype($body)) {
                case 'string':
                    if (!$this->res->type($body)) {
                        $this->res->type('html');
                    }
                    break;
                case 'array':
                case 'object':
                    return $this->res->json($body);
                default:
                    throw new \TypeError('invalid body type to send');
            }

            // write strings in utf-8
            $encoding = 'utf8';
            $type = $this->res->get('Content-Type');

            if (is_string($type)) {
                $this->res->set('Content-Type', set_charset($type, 'utf-8'));
            }

            // determine if ETag should be generated
            if (!$this->app instanceof Application) {
                throw new \Error('$this->app property must be a instance of class Press\Application');
            }
            $etag_fn = $app ? $app->get('etag fn') : null;

            $generate_etag = !$this->res->get('ETag') && is_callable($etag_fn);

            $this->res->set('Content-Length', strlen($body));

            // populate ETag
            if ($generate_etag && is_callable($etag_fn)) {
                $etag = $etag_fn($body, $encoding);
                $this->res->set('Content-Length', $etag);
            }

            if (!($this->req instanceof Request)) {
                throw new \Error('$this->req must be a instance of class Press\Request');
            }

            // freshness
            if ($req->fresh) {
                $this->status_code = 304;
            }

            // strip irrelevant headers
            if (204 === $this->status_code || 304 === $this->status_code) {
                //todo: remove header
                $this->res->set('Content-Type', '');
                $this->res->set('Content-Length', '');
                $this->res->set('Transfer-Encoding', '');
                $chunk = '';
            }

            if ($req->method === 'HEAD') {
                // skip body for HEAD
                $this->res->end();
            } else {
                $this->res->end($chunk);
            }
        };
    }

    /**
     * @return \Closure
     */
    public function json()
    {
        return function ($body) {
            $body = json_encode($body);

            if (!$this->res->get('Content-Type')) {
                $this->res->set('Content-Type', 'application/json');
            }

            return $this->res->send($body);
        };
    }

    /**
     * @return \Closure
     */
    public function send_status()
    {
        return function ($status_code) {
            $body = Status\Status::status($status_code);

            $this->status_code = $status_code;
            $this->res->type('txt');

            return $this->res->send($body);
        };
    }

    /**
     * @return \Closure
     */
    public function send_file()
    {
        return function ($path) {
            $this->res->sendfile($path);
        };
    }

    /**
     * Append additional header `field` with value `val`.
     *
     * Example:
     *    res.append('Set-Cookie', 'foo=bar; Path=/; HttpOnly');
     *    res.append('Warning', '199 Miscellaneous warning');
     * @return \Closure
     */
    public function append()
    {
        return function ($field, $val) {
            $prev = $this->res->get($field);
            $value = $prev;

            if ($prev) {
                $value = "{$prev}{$val}";
            }

            $this->res->set($field, $value);
            return $this->res;
        };
    }


    /**
     * @return \Closure
     */
    public function location()
    {
        return function (string $url) {
            $loc = $url;

            if ($url === 'back') {
                $loc = $this->req->get('Referrer');
                $loc = !$loc ? '/' : $loc;
            }

            return $this->res->set('Location', urlencode($loc));
        };
    }

    public function clear_cookie()
    {

    }

//    /**
//     * @param $location
//     * @param $http_code
//     */
//    public function redirect($location, $http_code = null)
//    {
//        parent::redirect($location, $http_code);
//    }

    /**
     * Add `field` to Vary. If already present in the Vary set, then
     * this call is simply ignored.
     * @return \Closure
     */
    public function vary()
    {
        return function ($field) {
            Vary::vary($this, $field);
            return $this;
        };
    }

    public function render()
    {

    }
}
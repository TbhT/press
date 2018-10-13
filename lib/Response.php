<?php
declare(strict_types=1);

namespace Press;

use Press\Utils\ContentType;
use Press\Utils\Mime\MimeTypes;
use Press\Utils\Status;
use Press\Utils\Vary;
use Swoole\Http\Response as SResponse;


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
 * @package Press
 */
class Response extends SResponse
{
    public $headers;
    private $status_code;
    private $req = null;
    private $app = null;

    public function __construct()
    {
        $this->headers = $this->header;
    }

    /**
     * set http header info
     * @param $key
     * @param $value
     * @param null $ucwords
     * @return Response
     */
    public function header($key, $value, $ucwords = null)
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
     * @param {string|number} $code
     * @return Response
     */
    public function status($code)
    {
        parent::status($code);
        $this->status_code = $code;
        return $this;
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
    public function content_type(string $type)
    {
        return $this->type($type);
    }


    /**
     * @param string $body
     * @return $this
     */
    public function send($body = '')
    {
        //settings
        $app = $this->app;
        $req = $this->req;

        switch (gettype($body)) {
            case 'string':
                if (!$this->type($body)) {
                    $this->type('html');
                }
                break;
            case 'array':
            case 'object':
                return $this->json($body);
            default:
                throw new \TypeError('invalid body type to send');
        }

        // write strings in utf-8
        $encoding = 'utf8';
        $type = $this->get('Content-Type');

        if (is_string($type)) {
            $this->set('Content-Type', set_charset($type, 'utf-8'));
        }

        // determine if ETag should be generated
        $etag_fn = $app ? $app->get('etag fn') : null;

        $generate_etag = !$this->get('ETag') && is_callable($etag_fn);

        $this->set('Content-Length', strlen($body));

        // populate ETag
        if ($generate_etag && is_callable($etag_fn)) {
            $etag = $etag_fn($body, $encoding);
            $this->set('Content-Length', $etag);
        }

        // freshness
        if ($req && $req->fresh) {
            $this->status_code = 304;
        }

        // strip irrelevant headers
        if (204 === $this->status_code || 304 === $this->status_code) {
            //todo: remove header
            $this->set('Content-Type', '');
            $this->set('Content-Length', '');
            $this->set('Transfer-Encoding', '');
            $chunk = '';
        }

        if ($req && $req->method === 'HEAD') {
            // skip body for HEAD
            $this->end();
        } else {
            $this->end($chunk);
        }

        return $this;
    }

    /**
     * @param $body
     * @return Response
     */
    public function json($body)
    {
        $body = json_encode($body);

        if (!$this->get('Content-Type')) {
            $this->set('Content-Type', 'application/json');
        }

        return $this->send($body);
    }

    /**
     * @param $status_code
     * @return Response
     */
    public function send_status($status_code)
    {
        $body = Status\Status::status($status_code);

        $this->status_code = $status_code;
        $this->type('txt');

        return $this->send($body);
    }

    /**
     * @param $path
     * @return $this
     */
    public function send_file($path)
    {
        parent::sendfile($path);
        return $this;
    }

    /**
     * Append additional header `field` with value `val`.
     *
     * Example:
     *    res.append('Set-Cookie', 'foo=bar; Path=/; HttpOnly');
     *    res.append('Warning', '199 Miscellaneous warning');
     * @param $field
     * @param $val
     * @return Response
     */
    public function append($field, $val)
    {
        $prev = $this->get($field);
        $value = $prev;

        if ($prev) {
            $value = "{$prev}{$val}";
        }

        $this->set($field, $value);
        return $this;
    }


    /**
     * @param string $url
     * @return Response
     */
    public function location(string $url)
    {
        $loc = $url;

        if ($url === 'back') {
            $loc = $this->req->get('Referrer');
            $loc = !$loc ? '/' : $loc;
        }

        return $this->set('Location', urlencode($loc));
    }

    public function clear_cookie()
    {

    }

    /**
     * @param $location
     * @param $http_code
     */
    public function redirect($location, $http_code)
    {
        parent::redirect($location, $http_code);
    }

    /**
     * Add `field` to Vary. If already present in the Vary set, then
     * this call is simply ignored.
     * @param $field
     * @return Response
     */
    public function vary($field)
    {
        Vary::vary($this, $field);
        return $this;
    }

    public function render()
    {

    }
}
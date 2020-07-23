<?php


namespace Press;


use Exception;
use Press\Utils\Accepts;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use function Press\Utils\ContentType\parse;
use function Press\Utils\fresh;
use function Press\Utils\typeIs;

/**
 * @property string|string[]|null host
 * @property string|string[]|null origin
 * @property array|string|string[]|null url
 * @property array|string|string[]|null querystring
 * @property array|string|string[]|null hostname
 * @property array|string|string[]|null method
 * @property array|string|string[]|null header
 * @property array|string|string[]|null headers
 * @property array|bool|string|string[]|null fresh
 * @property array|bool|false|int|mixed|string|string[]|null protocol
 * @property array|bool|false|int|mixed|string|string[] ips
 * @property array|bool|false|int|mixed|string|string[] ip
 * @property int|mixed|Accepts|string|string[] accept
 * @property string|null charset
 */
class Request
{
    public ?Context $ctx = null;

    public ?Response $response = null;

    public ?ServerRequestInterface $req = null;

    public ?\React\Http\Message\Response $res = null;

    public ?Application $app = null;

    public string $originalUrl = '';

    private ?Accepts $_accept = null;

    public function __get($name)
    {
        if ($name === 'header' || $name === 'headers') {
            return $this->getHeader();
        }

        if ($name === 'url') {
            return $this->getUrl();
        }

        if ($name === 'origin') {
            return $this->getOrigin();
        }

        if ($name === 'href') {
            return $this->getHref();
        }

        if ($name === 'method') {
            return $this->getMethod();
        }

        if ($name === 'path') {
            return $this->getPath();
        }

        if ($name === 'query') {
            return $this->getQuery();
        }

        if ($name === 'querystring') {
            return $this->getQuerystring();
        }

        if ($name === 'search') {
            return $this->getSearch();
        }

        if ($name === 'host' || $name === 'hostname') {
            return $this->getHost();
        }

        if ($name === 'fresh') {
            return $this->getFresh();
        }

        if ($name === 'stale') {
            return !$this->getFresh();
        }

        if ($name === 'idempotent') {
            return $this->getIdempotent();
        }

        if ($name === 'charset') {
            return $this->getCharset();
        }

        if ($name === 'length') {
            return $this->getLength();
        }

        if ($name === 'protocol') {
            return $this->getProtocol();
        }

        if ($name === 'secure') {
            return $this->getSecure();
        }

        if ($name === 'ips') {
            return $this->getIps();
        }

        if ($name === 'ip') {
            return $this->getIp();
        }

        if ($name === 'subdomains') {
            return $this->getSubdomains();
        }

        if ($name === 'accept') {
            return $this->getAccept();
        }

        if ($name === 'type') {
            return $this->getType();
        }

        if (isset($this->$name) === false) {
            return null;
        }

        return $this->$name;
    }

    public function __set($name, $value)
    {
        if ($name === 'header' || $name === 'headers') {
            $this->setHeader($value);
        } else if ($name === 'url') {
            $this->setUrl($value);
        } else if ($name === 'method') {
            $this->setMethod($value);
        } else if ($name === 'path') {
            $this->setPath($value);
        } else if ($name === 'query') {
            $this->setQuery($value);
        } else if ($name === 'querystring') {
            $this->setQuerystring($value);
        } else if ($name === 'search') {
            $this->setSearch($value);
        } else if ($name === 'ip') {
            $this->setIp($value);
        } else if ($name === 'accept') {
            $this->setAccept($value);
        } else if (!isset($this->$name)) {
            $this->$name = $value;
        }
    }

    public function __call($name, $args)
    {
        return call_user_func_array($this->$name, $args);
    }

    private function getHeader()
    {
        return $this->req->getHeaders();
    }

    private function setHeader($value)
    {
        foreach ($value as $key => $v) {
            $newReq = $this->req->withHeader($key, $v);

            if ($newReq) {
                $this->req = $newReq;
                $this->app->updateReq($newReq);
            }
        }
    }

    private function getUrl(): string
    {
        $uri = $this->req->getUri();
        return "{$uri->getPath()}?{$uri->getQuery()}";
    }

    private function setUrl(UriInterface $url)
    {
        $this->req = $this->req->withUri($url);
        $this->app->updateReq($this->req);
    }

    private function getOrigin()
    {
        $uri = $this->req->getUri();
        return "{$uri->getScheme()}://{$this->host}";
    }

    private function getHref()
    {
        if (preg_match('/^https?:\\/\\//', $this->originalUrl)) {
            return $this->originalUrl;
        }

        return "{$this->origin}{$this->originalUrl}";
    }

    private function getMethod(): string
    {
        return $this->req->getMethod();
    }

    private function setMethod($method)
    {
        $this->req = $this->req->withMethod($method);
        $this->app->updateReq($this->req);
    }

    private function getHost(): string
    {
        $proxy = $this->app->proxy;
        $host = null;

        if ($proxy) {
            $host = $this->get('X-Forwarded-Host');
        }

        if (!$host) {
            if ($this->req->getProtocolVersion() >= 2) {
                $host = $this->get(':authority');
            }
            if (!$host) {
                $host = $this->get('Host');
            }
        }

        if (!$host) {
            return '';
        }

        $host = preg_split('/\s*,\s*/', $host);
        return $host[0];
    }

    private function getPath()
    {
        $uri = $this->req->getUri();
        return $uri->getPath();
    }

    private function setPath(string $path)
    {
        $uri = $this->req->getUri()->withPath($path);
        $this->req = $this->req->withUri($uri);
        $this->app->updateReq($this->req);
    }

    private function getQuery()
    {
        return $this->req->getQueryParams();
    }

    private function setQuery(array $params)
    {
        $this->req = $this->req->withQueryParams($params);
        $this->app->updateReq($this->req);
    }

    private function getQuerystring()
    {
        $queryParams = $this->getQuery();
        $kvArray = [];

        foreach ($queryParams as $key => $value) {
            array_push($kvArray, "{$key}=$value");
        }

        return join("&", $kvArray);
    }

    private function setQuerystring(string $str)
    {
        $this->url = $str;
    }

    private function getSearch()
    {
        if (!$this->querystring) {
            return "";
        }

        return "?{$this->querystring}";
    }

    private function setSearch(string $str)
    {
        $this->querystring = $str;
    }

    private function getHostname()
    {
        if (!$this->host) {
            return "";
        }

        return $this->hostname;
    }

    private function getFresh()
    {
        $method = $this->method;
        $status = $this->ctx->status;

        if ($method !== 'GET' && $method !== 'HEAD') {
            return false;
        }

        // 2xx or 304 as per rfc2616 14.26
        if ($status >= 200 && $status < 300 || $status === 304) {
            return fresh($this->header, $this->response->header);
        }

        return false;
    }

    private function getIdempotent()
    {
        $methods = ['GET', 'HEAD', 'PUT', 'DELETE', 'OPTIONS', 'TRACE'];
        return array_search($this->method, $methods);
    }

    private function getSocket()
    {
//        todo:
    }

    private function getCharset()
    {
        try {
            $types = parse($this);
            return $types['parameters']['charset'] ?? "";
        } catch (Exception $error) {
            return '';
        }
    }

    private function getLength()
    {
        $length = $this->get('Content-Length');
        return ~~$length;
    }

    private function getProtocol()
    {
        $uri = $this->req->getUri();
        $schema = $uri->getScheme();
        if (!$this->app->proxy) {
            return $schema;
        }

        $proto = $this->get('X-Forwarded-Proto');
        $ar = [];
        if ($proto) {
            preg_match('/\s*,\s*/', $proto, $ar);
        }

        return $proto ? $ar[0] : 'http';
    }

    private function getSecure()
    {
        return $this->protocol === 'https';
    }

    private function getIps()
    {
        $proxy = $this->app->proxy;
        $value = $this->get($this->app->proxyIpHeader);
        $ar = [];

        if ($proxy && $value) {
            preg_match('/\s*,\s*/', $value, $ar);
        }

        if ($this->app->maxIpCount > 0) {
            $ar = array_slice($ar, $this->app->maxIpCount);
        }

        return $ar;
    }

    private function getIp()
    {
        if (count($this->ips) > 0) {
            return $this->ips[0];
        }

        return '';
    }

    private function setIp($value)
    {
        $this->ip = $value;
    }

    private function getSubdomains()
    {
        $offset = $this->app->subdomainOffset;
        $hostname = $this->hostname;
        if (filter_var($hostname, FILTER_VALIDATE_IP)) {
            $ar = array_slice(explode($hostname, '.'), $offset);
            return array_reverse($ar);
        }

        return [];
    }

    private function getAccept()
    {
        if (!$this->_accept) {
            $this->_accept = new Accepts($this);
        }

        return $this->_accept;
    }

    private function setAccept($value)
    {
        $this->_accept = $value;
    }

    public function accepts()
    {
        $args = func_get_args();
        return $this->accept->types(...$args);
    }

    public function acceptsEncodings(...$args)
    {
        return $this->accept->encoding(...$args);
    }

    public function acceptsCharsets(...$args)
    {
        return $this->accept->charsets(...$args);
    }

    public function acceptsLanguages(...$args)
    {
        return $this->accept->languages(...$args);
    }

    public function is(...$args)
    {
        $type = $args[0];
        $args = array_slice($args, 1);
        return typeIs($this, $type, ...$args);
    }

    private function getType()
    {
        $type = $this->get('Content-Type');
        if (!$type) {
            return '';
        }

        $ar = explode(';', $type);
        return $ar[0];
    }

    public function get(string $field)
    {
        $lowerField = strtolower($field);

        switch ($lowerField) {
            case 'referer':
            case 'referrer':
            {
                $result = $this->req->getHeader('referer') ?? $this->req->getHeader('referrer') ?? "";
                break;
            }
            default:
            {
                $result = $this->req->getHeader($lowerField);
                break;
            }
        }

        $result = join('', $result);
        return $result;
    }

}
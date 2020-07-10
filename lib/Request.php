<?php


namespace Press;


use Exception;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use function Press\Utils\ContentType\parse;
use function Press\Utils\fresh;

/**
 * @property string|\string[][]|null host
 * @property string|\string[][]|null origin
 * @property array|string|\string[][]|null url
 * @property array|string|\string[][]|null querystring
 * @property array|string|\string[][]|null hostname
 * @property array|string|\string[][]|null method
 * @property array|string|\string[][]|null header
 * @property array|bool|string|\string[][]|null fresh
 * @property array|bool|false|int|mixed|string|\string[][]|null protocol
 * @property array|bool|false|int|mixed|string|\string[][] ips
 * @property array|bool|false|int|mixed|string|\string[][] ip
 */
class Request
{
    public ?Context $ctx = null;

    public ?Response $response = null;

    public ?ServerRequestInterface $req = null;

    public ?\React\Http\Response $res = null;

    public ?Application $app = null;

    public string $originalUrl = '';

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

        return null;
    }

    public function __set($name, $value)
    {
        if ($name === 'header' || $name === 'headers') {
            $this->setHeader($name, $value);
        }

        if ($name === 'url') {
            $this->setUrl($value);
        }

        if ($name === 'method') {
            $this->setMethod($value);
        }

        if ($name === 'path') {
            $this->setPath($value);
        }

        if ($name === 'query') {
            $this->setQuery($value);
        }

        if ($name === 'querystring') {
            $this->setQuerystring($value);
        }

        if ($name === 'search') {
            $this->setSearch($value);
        }

        if ($name === 'ip') {
            $this->setIp($value);
        }

        if (!isset($this->$name)) {
            $this->$name = $value;
        }
    }

    private function getHeader()
    {
        return $this->req->getHeaders();
    }

    private function setHeader($name, $value)
    {
        $this->req->withHeader($name, $value);
    }

    private function getUrl(): string
    {
        $uri = $this->req->getUri();
        return "{$uri->getPath()}?{$uri->getQuery()}";
    }

    private function setUrl(UriInterface $url)
    {
        $this->req->withUri($url);
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
        $this->req->withMethod($method);
    }

    private function getHost(): string
    {
        $uri = $this->req->getUri();
        return $uri->getHost();
    }

    private function getPath()
    {
        $uri = $this->req->getUri();
        return $uri->getPath();
    }

    private function setPath(string $path)
    {
        $uri = $this->req->getUri();
        $uri->withPath($path);
    }

    private function getQuery()
    {
        return $this->req->getQueryParams();
    }

    private function setQuery(array $params)
    {
        $this->req->withQueryParams($params);
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
        if ($status >= 200 && $status < 300) {
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
            $types = parse($this->req);
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
        if (!filter_var($hostname, FILTER_VALIDATE_IP)) {
            $ar = array_slice(explode($hostname, '.'), $offset);
            return array_reverse($ar);
        }

        return [];
    }

    private function getAccept()
    {
//        todo:
    }

    private function setAccept()
    {
//        todo:
    }

    public function accepts()
    {
//        todo:
    }

    public function acceptsEncodings()
    {
//        todo:
    }

    public function acceptsCharsets()
    {
//      todo:
    }

    public function acceptsLanguages()
    {
//        todo:
    }

    public function is()
    {
//        todo:
    }

    private function getType()
    {
//        todo:
    }

    public function get(string $field)
    {
        $lowerField = strtolower($field);

        switch ($lowerField) {
            case 'referer':
            case 'referrer':
            {
                return $this->req->getHeader('referer') ?? $this->req->getHeader('referrer') ?? "";
            }
            default:
                return $this->req->getHeader($lowerField);
        }
    }

}
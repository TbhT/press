<?php


namespace Press;


use Exception;
use Press\Utils\Accepts;
use Psr\Http\Message\ServerRequestInterface;
use RingCentral\Psr7\Uri;
use function Press\Utils\ContentType\parse;
use function Press\Utils\fresh;
use function Press\Utils\typeOfRequest;
use function RingCentral\Psr7\build_query;
use function RingCentral\Psr7\parse_query;

/**
 * @property string|null host
 * @property string|null origin
 * @property string|null url
 * @property string|null querystring
 * @property string|null hostname
 * @property string|null method
 * @property array|string[]|null header
 * @property array|string[]|null headers
 * @property bool|null fresh
 * @property string|null type
 * @property int|null length
 * @property array|bool|false|int|mixed|string|string[]|null protocol
 * @property array|bool|false|int|mixed|string|string[] ips
 * @property array|bool|false|int|mixed|string|string[] ip
 * @property int|mixed|Accepts|string|string[] accept
 * @property string|null charset
 * @property array|int|mixed|Accepts|string|string[] secure
 * @property string|null idempotent
 * @property string[]|null query
 * @property string[]|null subdomains
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

    private string $ip = '';

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
        $path = $this->req->getUri()->getPath();
        $queryParams = $this->query;
        $qs = build_query($queryParams);
        return "{$path}" . (!$queryParams ? "" : "?{$qs}");
    }

    private function setUrl($url)
    {
        if (is_string($url)) {
            $url = new Uri($url);
        }

        $this->req = $this->req->withUri($url);
        $this->app->updateReq($this->req);
    }

    private function getOrigin()
    {
        $uri = $this->req->getUri();
        $protocol = $uri->getScheme();
        if (!$protocol) {
            $protocol = $this->secure ? 'https' : 'http';
        }

        return "{$protocol}://{$this->host}";
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
        $qs = $this->req->getQueryParams();
        $originalQs = $this->req->getUri()->getQuery();

        if ($originalQs && $originalQs[0] === '?') {
            $originalQs = trim($originalQs, '?');
        }

        return array_merge($qs, parse_query($originalQs));
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
        $path = $this->req->getUri()->getPath();
        $this->url = "{$path}?{$str}";
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
        return array_search($this->method, $methods) !== false;
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
        return (int)$length;
    }

    private function getProtocol()
    {
        if (!$this->app->proxy) {
            return 'http';
        }

        $proto = $this->get('X-Forwarded-Proto');
        $ar = [];
        if ($proto) {
            $ar = preg_split('/\s*,\s*/', $proto);
            if (!$ar) {
                $ar = [];
            }
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
            $ar = preg_split('/\s*,\s*/', $value);
            if (!$ar) {
                $ar = [];
            }
        }

        $serverParams = $this->req->getServerParams();
        if (isset($serverParams['REMOTE_ADDR'])) {
            return [$serverParams['REMOTE_ADDR']];
        }

        if ($this->app->maxIpCount > 0) {
            $ar = array_slice($ar, $this->app->maxIpCount);
        }

        return $ar;
    }

    private function getIp()
    {
        if (!$this->ip) {
            $this->ip = $this->ips[0];
        }

        return $this->ip;
    }

    private function setIp($value)
    {
        $this->ip = $value;
    }

    private function getSubdomains()
    {
        $offset = $this->app->subdomainOffset;
        $hostname = filter_var($this->hostname, FILTER_VALIDATE_IP);

        if (count(explode(':', $this->hostname)) > 1) {
            return [];
        }

        if (!$hostname) {
            return array_slice(array_reverse(explode('.', $this->hostname)), $offset);
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
        $type = $args[0] ?? null;
        $args = array_slice($args, 1);
        return typeOfRequest($this, $type, ...$args);
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

        $result = join(',', $result);
        return $result;
    }

}
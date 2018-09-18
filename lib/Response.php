<?php
declare(strict_types=1);

namespace Press;
use Swoole\Http\Response as SResponse;


class Response extends SResponse
{
    public $headers;

    public function __construct()
    {
        $this->headers = $this->header;
    }
}
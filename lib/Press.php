<?php
declare(strict_types=1);

namespace Press;
use Swoole\Http\Request as Req;
use Swoole\Http\Response as Res;


class Press
{
    use Application;

    public function __construct()
    {
        $this->VERDSInit();
    }

    public function press()
    {
        return function (Req $req, Res $res, $next = null) {
            $this->handle($req, $res, $next);
        };
    }

}
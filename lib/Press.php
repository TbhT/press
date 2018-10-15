<?php
declare(strict_types=1);

namespace Press;


class Press
{
    use Application;

    public function __construct()
    {
        $this->VERDSInit();
        $this->request = new Request();
        $this->response = new Response();
    }

    public function press()
    {
        return function (Request $req, Response $res, $next = null) {
            $this->handle($req, $res, $next);
        };
    }

}
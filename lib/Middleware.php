<?php

namespace Press;

use Press\Helper\Mixin;
use Press\Utils\FinalHanlder;
use Swoole\Http\Response;
use Swoole\Http\Request;


/**
 * Class Middleware
 * @package Press
 */
class Middleware
{
    /**
     * @param Press $app
     * @return \Closure
     */
    public static function init($app)
    {
        /**
         * @param Request $req
         * @param Response $res
         * @param callable $next
         */
        return function (Request $req, Response $res, callable $next) use ($app) {
            if ($app->enabled('x-power-by')) {
                $res->set('X-Power-By', 'Press');
            }

            $req->res = $res;
            $res->req = $req;
            $req->next = $next;

            Mixin::request($req);
            Mixin::response($res);

            $res->locals = empty($res->locals) ? [] : $res->locals;

            $next();
        };
    }

    /**
     * @return \Closure
     */
    public static function query()
    {
        return function () {

        };
    }

    /**
     * @param Request $req
     * @param Response $res
     * @param array $option
     * @return \Closure
     */
    public static function final_handler(Request $req, Response $res, array $option)
    {
        return function () use ($req, $res, $option) {
            FinalHanlder::final_handler($req, $res, $option);
        };
    }
}
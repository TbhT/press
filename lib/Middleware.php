<?php

namespace Press;

use Press\Helper\Mixin;
use Press\Utils\FinalHandler;
use Press\Response;
use Press\Request;


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

            $req->res = $res;
            $res->req = $req;
            $req->next = $next;

            Mixin::request($req);
            Mixin::response($res);

            $res->locals = empty($res->locals) ? [] : $res->locals;

            if ($app->enabled('x-power-by')) {
                $res->set('X-Power-By', 'Press');
            }
            echo "init----------------\n";

            $next();
        };
    }

    /**
     * @return \Closure
     */
    public static function query()
    {
        return function (Request $req, Response $res, $next) {
            echo "query-------------------\n";
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
        return FinalHandler::final_handler($req, $res, $option);
    }
}

<?php

declare(strict_types=1);


namespace Press\Tool;


class HttpHelper
{
    static private $_safe_methods = ['get', 'head', 'options', 'pri', 'propfind', 'report', 'search', 'trace'];


    static private $_unsafe_methods = [
        'acl', 'baseline-control', 'bind', 'checkin', 'checkout', 'connect', 'copy', 'delete', 'label', 'link',
        'lock', 'merge', 'mkactivity', 'mkcalendar', 'mkcol', 'mkredirectref', 'mkworksapce', 'move', 'orderpatch',
        'patch', 'post', 'proppatch', 'put', 'rebind', 'unbind', 'uncheckout', 'unlink', 'unlock', 'update',
        'updateredirectref', 'version-control'
    ];


    static public function safeMethods(): array
    {
        return self::$_safe_methods;
    }


    static public function unSafeMethods(): array
    {
        return self::$_unsafe_methods;
    }


    static public function methods(): array
    {
        return array_merge(self::$_unsafe_methods, self::$_safe_methods);
    }


}
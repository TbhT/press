<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-28
 * Time: 下午10:40
 */

namespace Press\Utils\Mime;


function extname(string $str)
{
    $str_array = explode('.', $str);
    $str_array_length = count($str_array);

    if ($str_array_length > 0) {
        return $str_array[$str_array_length - 1];
    }

    return '';
}


class MimeTypes
{
    private $preference = ['nginx', 'apache', null, 'iana'];

    public static $extensions = [];
    public static $types = [];

    public static function populateMaps($extensions, $types)
    {
        foreach (array_keys(MIMEDB) as $type) {
            $mime = MIMEDB[$type];
            $exts = $mime['extensions'];

            if (empty($exts) || count($exts) === 0) {
                return null;
            }

            $extensions[$type] = $exts;

            foreach ($exts as $extension) {
                if ($types[$extension]) {

                }
            }
        }
    }


    public static function charset($type)
    {
        if (empty($type) || is_string($type) === false) {
            return false;
        }

//        extract type regexp
        preg_match('/^\s*([^;\s]*)(?:;|\s|$)/', $type, $matches);
        $mime = $matches && strtolower(MIMEDB[$matches[1]]);

        if ($mime && array_key_exists('charset', $mime)) {
            return $mime['charset'];
        }

//        default text/* to utf-8
        if (count($matches) > 0) {
            preg_match('/^text\//', $matches[1], $text_matches);
            if (count($text_matches) > 0) {
                return 'UTF-8';
            }
        }

        return false;
    }


    private static function contentType(string $str)
    {
        if (empty($str) || is_string($str) === false) {
            return false;
        }

        $mime = strpos($str, '/') === false ? self::loopup($str) : $str;

        if (empty($mime)) {
            return false;
        }

//        todo: use content-type or other module
        if (strpos($mime, 'charset') === false) {
            $charset = self::charset($mime);
            if ($mime) {
                $mime .= '; charset=' . strtolower($charset);
            }
        }

        return $mime;
    }


    public function lookup(string $path)
    {
        if (empty($path) || is_string($path) === false) {
            return false;
        }

        $extension = strtolower(extname('x.' . $path));
        $extension = substr($extension, 1);

        if (empty($extension)) {
            return false;
        }

        return self::$types[$extension] || false;
    }

}



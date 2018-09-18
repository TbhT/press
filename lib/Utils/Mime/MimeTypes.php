<?php
declare(strict_types=1);

namespace Press\Utils\Mime;


const PREFERENCE = ['nginx', 'apache', null, 'iana'];


function extname(string $str)
{
    preg_match('/(^\.\w+$)|([\w\d.:\/\\\\]+)/', $str, $matches);
    $matches_length = count($matches);

    if ($matches_length === 2) {
//    for extension
        $extname = substr($str, 1);
    } else if ($matches_length === 3) {
//    for path
        $file_info = pathinfo($matches[2]);
        $extname = array_key_exists('extension', $file_info) ?
            $file_info['filename'] === '' ? '' : $file_info['extension'] : '';
    } else {
        $extname = '';
    }

    return $extname;
}


function populateMaps($extensions, $types)
{
    $mime_db = MimeDb::get();

    foreach (array_keys($mime_db) as $type) {
        $mime = $mime_db[$type];

        if (array_key_exists('extensions', $mime) === false || empty($mime['extensions'])) {
            continue;
        }

        $extensions[$type] = $mime['extensions'];

//            extension -> mime
        foreach ($mime['extensions'] as $extension) {
            if (array_key_exists($extension, $types)) {
                $from = $to = null;
                $mime_db_key = $types[$extension];
                foreach (PREFERENCE as $k => $v) {
                    if (array_key_exists('source', $mime_db[$mime_db_key])
                        && $v === $mime_db[$mime_db_key]['source']) {
                        $from = $k;
                    }

                    if (array_key_exists('source', $mime) && $v === $mime['source']) {
                        $to = $k;
                    }
                }

                $flag = array_key_exists($extension, $types) ? $types[$extension] !== 'application/octet-stream' && ($from > $to ||
                        ($from === $to && substr($types[$extension], 0, 12) === 'application/')) : false;

                if ($flag) {
                    continue;
                }
            }

//                set the extensions -> mime
            $types[$extension] = $type;
        }
    }

    return [
        $extensions,
        $types
    ];
}


class MimeTypes
{

    public static function charset($type)
    {
        if (empty($type) || is_string($type) === false) {
            return false;
        }

//        extract type regexp
        preg_match('/^\s*([^;\s]*)(?:;|\s|$)/', $type, $matches);
        $mime_db = MimeDb::get();
        $mime = count($matches) > 0 && array_key_exists(strtolower($matches[1]), $mime_db) ?
            $mime_db[strtolower($matches[1])] : null;

        if ($mime && array_key_exists('charset', $mime)) {
            return $mime['charset'];
        }

//        default text/* to utf-8
        if (count($matches) > 0) {
            preg_match('/^text\//i', $matches[1], $text_matches);
            if (count($text_matches) > 0) {
                return 'UTF-8';
            }
        }

        return false;
    }


    public static function contentType($str)
    {
        if (empty($str) || is_string($str) === false) {
            return false;
        }

        $mime = strpos($str, '/') === false ? self::lookup($str) : $str;

        if (empty($mime)) {
            return false;
        }

//        todo: use content-type or other module
        if (strpos($mime, 'charset') === false) {
            $charset = self::charset($mime);
            if ($charset) {
                $mime .= '; charset=' . strtolower($charset);
            }
        }

        return $mime;
    }


    public static function lookup($path)
    {
        if (empty($path) || is_string($path) === false) {
            return false;
        }

        $extension = strtolower(extname('x.' . $path));

        if (empty($extension)) {
            return false;
        }

//        self::populateMaps(self::$extensions, self::$types);
        $maps = populateMaps([], []);

        return array_key_exists($extension, $maps[1]) ? $maps[1][$extension] : false;
    }


    public static function extension($type)
    {
        if (empty($type) || is_string($type) === false) {
            return false;
        }

//        self::populateMaps(self::$extensions, self::$types);
        $maps = populateMaps([], []);

        preg_match('/^\s*([^;\s]*)(?:;|\s|$)/', $type, $matches);

//        get extensions
        $exts = count($matches) > 0
            ? array_key_exists(strtolower($matches[1]), $maps[0])
                ? $maps[0][strtolower($matches[1])] : null
            : null;

        if (empty($exts) || count($exts) === 0) {
            return false;
        }

        return $exts[0];
    }
}



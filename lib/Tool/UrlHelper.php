<?php

declare(strict_types=1);


namespace Press\Tool;


/**
 * Class UrlHelper
 * @package Press\Tool
 */
class UrlHelper
{

    /**
     * @param mixed $path a preg patterns or a array of patterns
     * @param array $keys
     * @param array $options
     * @return string
     */
    static public function pathToRegExp($path, array & $keys, array $options): string
    {
        $array_flag = is_array($options);
        $strict = $array_flag && array_key_exists('strict', $options) ? $options['strict'] : false;
        $end = $array_flag && array_key_exists('end', $options) ? $options['end'] : true;
        $flags = $array_flag && !empty($options['sensitive']) ? '' : 'i';
        $index = 0;


        if (is_array($path)) {
            $path_array = array_map(function ($item) use (& $keys, & $options) {
                return self::getRegExpSource(static::pathToRegExp($item, $keys, $options));
            }, $path);

            return '`(?:' . join('|', $path_array) . ')`' . $flags;
        }

        $path_regexps = [
            '(\\\\.)',
//        match express style parameters and un-named parameters with a prefix and optional suffixes
//        such as:
//        '/:test(\\d+)?' => ['/', 'test', '\d+', undefined, '?']
//        "/route(\\d+)" => [undefined, undefined, undefined, "\d+", undefined]
            '([\\/.])?(?:\\:(\\w+)(?:\\(((?:\\\\.|[^)])*)\\))?|\\(((?:\\\\.|[^)])*)\\))([+*?])?',
            '([.+*?=^!:${}()[\\]|\\/])'
        ];

        $path_regexps = '/' . join('|', $path_regexps) . '/';

        $path = preg_replace_callback($path_regexps, function ($all_matches) use (& $keys, & $index) {
            $length = count($all_matches);

            if ($length > 1) {
//                $path_regexps 中的第一个数组， 匹配是否有被 转义的字符  /(\\.)/
                $escaped = $all_matches[1];
            }

            if ($length > 2) {
//              匹配 . 或者 / 开头的前缀
                $prefix = $all_matches[2];
            }

            if ($length > 3) {
//              匹配 :name 类型的 key
                $key = $all_matches[3];
            }

            if ($length > 4) {
//              匹配 :name 后面的 capture group
                $capture = $all_matches[4];
            }

            if ($length > 5) {
//              匹配 path 中的 group
                $group = $all_matches[5];
            }

            if ($length > 6) {
//              匹配后缀 * + ?
                $suffix = $all_matches[6];
            } else {
                $suffix = '';
            }

            if ($length > 7) {
//              匹配特殊字符
                $escape = $all_matches[7];
            }

//            avoiding re-escaping escaped characters
            if (!empty($escaped)) {
                return $escaped;
            }

//            转义特殊字符
            if (!empty($escape)) {
                return '\\' . $escape;
            }

            $repeat = $suffix === '+' || $suffix === '*';
            $optional = $suffix === '?' || $suffix === '*';

            array_push($keys, [
                'name' => (string) (!empty($key) ? $key : $index++),
                'delimiter' => !empty($prefix) ? $prefix : '/',
                'optional' => $optional,
                'repeat' => $repeat
            ]);

            $prefix = !empty($prefix) ? '\\' . $prefix : '';

            $subject = (!empty($capture) ? $capture : (!empty($group) ? $group : '[^' . (!empty($prefix) ? $prefix : '\\/') . ']+?'));

            $capture = preg_replace('/([=!:$\/()])/', '\1', $subject);


            if (!empty($repeat)) {
                $capture = $capture . '(?:' . $prefix . $capture . ')*';
            }

            if (!empty($optional)) {
                return '(?:' . $prefix . '(' . $capture . '))?';
            }

            return $prefix . '(' . $capture . ')';
        }, $path);


        $ends_with_slash = substr($path, -1, 1) === '/';

        if (!$strict) {
            $path = ($ends_with_slash ? substr($path, 0, -2) : $path) . '(?:\\/(?=$))?';
        }

        if (!$end) {
            $path .= ($strict && $ends_with_slash ? '' : '(?=\\/|$)');
        }


        return '/^' . $path . ($end ? '$' : '') . '/' . $flags;
    }


    /**
     * @param $regexp
     * @return bool|string
     */
    private static function getRegExpSource($regexp)
    {
        $delimiter = substr($regexp, 0, 1);
        $end_dlmt_pos = strrpos($regexp, $delimiter);
        $source = substr($regexp, 1, $end_dlmt_pos - 1);
        return $source;
    }


    /**
     * @param $regexp
     * @param $route
     * @return null
     */
    static public function match(string $regexp, $route)
    {
        preg_match_all($regexp, $route, $matches);

        if (count($matches) === 0) {
            $matches = null;
        } else {
            $is_values_null = true;
            foreach ($matches as $key => $value) {
                if (!empty($value)) {
//                    todo 当返回不为空的时候， 需要查看一下 $value 的值
                    $matches[$key] = $value[0];
                    $is_values_null = false;
                } else {
                    $matches[$key] = null;
                }
            }

            if ($is_values_null) {
                $matches = null;
            }
        }

        return $matches;
    }
}
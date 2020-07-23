<?php
declare(strict_types=1);

namespace Press\Utils;


const CACHE_CONTROL_NO_CACHE_REG_EXP = '/(?:^|,)\s*?no-cache\s*?(?:,|$)/';


function fresh(array $req_headers, array $res_headers)
{
    // fields
    $modified_since = $req_headers['if-modified-since'] ?? '';
    $none_match_val = $req_headers['if-none-match'] ?? '';

    // unconditional request
    if (!$modified_since && !$none_match_val) {
        return false;
    }

    // always return stale when Cache-Control: no-cache to support end-to-end reload requests
    // @link https://tools.ietf.org/html/rfc2616#section-14.9.4
    $cache_control = $req_headers['cache-control'] ?? '';
    if ($cache_control) {
        if (is_array($cache_control)) {
            $cache_control = join('', $req_headers['cache-control']);
        }
        preg_match(CACHE_CONTROL_NO_CACHE_REG_EXP, $cache_control, $cache_control_m);
        if (count($cache_control_m) !== 0) {
            return false;
        }
    }

    // if-none-match
    if (is_array($none_match_val)) {
        $none_match_val = join('', $none_match_val);
    }

    if ($none_match_val && $none_match_val !== '*') {
        $etag = array_key_exists('etag', $res_headers) ? $res_headers['etag'] : '';

        if (!$etag) {
            return false;
        } else if (is_array($res_headers['etag'])) {
            $etag = join('', $res_headers['etag']);
        }

        $etag_stale = true;
        $matches = parseToTokenList($none_match_val);
        foreach ($matches as $match) {
            if ($match === $etag || $match === ('W/' . $etag) || ('W/' . $match) === $etag) {
                $etag_stale = false;
                break;
            }
        }

        if ($etag_stale) {
            return false;
        }
    }

    // if-modified-since
    if ($modified_since) {
        $last_modified = array_key_exists('last-modified', $res_headers) ? $res_headers['last-modified'] : '';
        if (is_array($req_headers['if-modified-since'])) {
            $modified_since = join('', $req_headers['if-modified-since']);
        }

        $modified_stale = !$last_modified || !parseHttpDate($last_modified, $modified_since);

        if ($modified_stale) {
            return false;
        }
    }

    return true;
}


function parseToTokenList(string $str)
{
    $end = 0;
    $list = [];
    $start = 0;

    // gather tokens
    $length = strlen($str);
    for ($i = 0; $i < $length; $i++) {
        switch (ord($str[$i])) {
            case 32: /* */
                if ($start === $end) {
                    $start = $end = $i + 1;
                }
                break;
            case 44: /* , */
                array_push($list, substr($str, $start, $end));
                $start = $end = $i + 1;
                break;
            default:
                $end = $i + 1;
                break;
        }
    }

    // final token
    array_push($list, substr($str, $start, $end));

    return $list;
}


function parseHttpDate($last_modified, $modified_since)
{
    $last_modified = strtotime($last_modified);
    $modified_since = strtotime($modified_since);

    if (!is_integer($last_modified) || !is_integer($modified_since)) {
        return false;
    }

    return $last_modified <= $modified_since;

}
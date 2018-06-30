<?php
declare(strict_types=1);
/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-6-28
 * Time: 下午10:40
 */

namespace Press\Utils\Mime;


class MimeTypes
{
    private static function parseMimeDb(): \stdClass
    {
        $db_path = dirname(__DIR__ . '/db.json');
        return json_decode(file_get_contents($db_path));
    }


}
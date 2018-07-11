<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-7-11
 * Time: 下午11:32
 */

use Press\Utils\Negotiator\Encoding;
use PHPUnit\Framework\TestCase;


class EncodingTest extends TestCase
{

    /**
     * accept-encoding, expected
     * @return array
     */
    public function encodingData()
    {
        return [
            [
                null, 'identity'
            ],
            [
                '*', '*'
            ],
            [
                '*, gzip', '*'
            ],
            [
                '*, gzip;q=0', '*'
            ],
            [
                '*;q=0', null
            ],
            [
                '*;q=0, identity;q=1', 'identity'
            ],
            [
                'identity', 'identity'
            ],
            [
                'identity;q=0', null
            ],
            [
                'gzip', 'gzip'
            ],
            [
                'gzip, compress;q=0', 'gzip'
            ],
            [
                'gzip, deflate', 'gzip'
            ],
            [
                'gzip;q=0.8, deflate', 'deflate'
            ],
            [
                'gzip;q=0.8, identity;q=0.5, *;q=0.3', 'gzip'
            ]
        ];
    }

    /**
     * accept-encoding, expected, charset
     * @return array
     */
    public function encodingArrayData()
    {
        return [
            [
                null, null, []
            ],
            [
                null, 'identity', ['identity']
            ],
            [
                null, null, ['gzip']
            ],
            [
                '*', null, []
            ],
            [
                '*', 'identity', ['identity']
            ],
            [
                '*', 'gzip', ['gzip']
            ],
            [
                '*', 'gzip', ['gzip', 'identity']
            ],
            [
                '*, gzip', 'identity', ['identity']
            ],
            [
                '*, gzip', 'gzip', ['gzip']
            ],
            [
                '*, gzip', 'gzip', ['compress', 'gzip']
            ]
        ];
    }
}

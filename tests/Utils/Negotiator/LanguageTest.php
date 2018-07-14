<?php
declare(strict_types=1);

/**
 * Created by PhpStorm.
 * User: erub
 * Date: 18-7-12
 * Time: 下午11:12
 */

use Press\Utils\Negotiator\Language;
use PHPUnit\Framework\TestCase;


class LanguageTest extends TestCase
{

    /**
     * accept-language, expected
     * @return array
     */
    public function languageData()
    {
        return [
            [
                null, '*'
            ],
            [
                '*', '*'
            ],
            [
                '*, en', '*'
            ],
            [
                '*, en;q=0', '*'
            ],
            [
                '*;q=0.8, en, es', 'en'
            ],
            [
                'en', 'en'
            ],
            [
                'en;q=0', null
            ],
            [
                'en;q=0.8, es', 'es'
            ],
            [
                'en;q=0.9, es;q=0.8; en;q=0.7', 'en'
            ],
            [
                'en-US, en;q=0.8', 'en-US'
            ],
            [
                'en-US, en-GB', 'en-US'
            ],
            [
                'en-US;q=0.8, es', 'es'
            ],
            [
                'nl;q=0.5, fr, de, en, it, es, pt, no, se, fi, ro', 'fr'
            ]
        ];
    }

    /**
     * accept-language, language, expect
     * @return array
     */
    public function languageArrayData()
    {
        return [
            [
                null, [], null
            ],
            [
                null, ['en'], 'en'
            ],
            [
                null, ['es', 'en'], 'es'
            ],
            [
                '*', [], null
            ],
            [
                '*', ['en'], 'en'
            ],
            [
                '*', ['es', 'en'], 'es'
            ],
            [
                '*, en', [], null
            ],
            [
                '*, en', ['en'], 'en'
            ],
            [
                '*, en', ['es', 'en'], 'en'
            ],
            [
                '*, en;q=0', [], null
            ],
            [
                '*, en;q=0', ['en'], null
            ],
            [
                '*, en;q=0', ['es', 'en'], 'es'
            ],
            [
                '*;q=0.8, en, es', ['en', 'nl'], 'en'
            ],
            [
                '*;q=0.8, en, es', ['ro', 'nl'], 'ro'
            ],
            [
                'en', [], null
            ],
            [
                'en', ['en'], 'en'
            ],
            [
                'en', ['es', 'en'], 'en'
            ],
            [
                'en', ['en-US'], 'en-US'
            ],
            [
                'en', ['en-US', 'en'], 'en'
            ],
            [
                'en', ['en', 'en-US'], 'en'
            ],
            [
                'en;q=0', [], null
            ],
            [
                'en;q=0', ['es', 'en'], null
            ],
            [
                'en;q=0.8, es', [], null
            ],
            [
                'en;q=0.8, es', ['en'], 'en'
            ],
            [
                'en;q=0.8, es', ['en', 'es'], 'es'
            ],
            [
                'en;q=0.9, es;q=0.8, en;q=0.7', ['es'], 'es'
            ],
            [
                'en;q=0.9, es;q=0.8, en;q=0.7', ['en', 'es'], 'en'
            ],
            [
                'en;q=0.9, es;q=0.8, en;q=0.7', ['es', 'en'], 'en'
            ],
            [
                'en-US, en;q=0.8', ['en', 'en-US'], 'en-US'
            ],
            [
                'en-US, en;q=0.8', ['en-GB', 'en-US'], 'en-US'
            ],
            [
                'en-US, en;q=0.8', ['en-GB', 'es'], 'en-GB'
            ],
            [
                'en-US, en-GB', ['en-US', 'en-GB'], 'en-US'
            ],
            [
                'en-US, en-GB', ['en-GB', 'en-US'], 'en-US'
            ],
            [
                'en-US, en-GB', ['en-US', 'en-GB'], 'en-US'
            ],
            [
                'en-US, en-GB', ['en-GB', 'en-US'], 'en-US'
            ],
            [
                'en-US;q=0.8, es', ['es', 'en-US'], 'es'
            ],
            [
                'en-US;q=0.8, es', ['en-US', 'es'], 'es'
            ],
            [
                'en-US;q=0.8, es', ['en-US', 'en'], 'en-US'
            ],
            [
                'nl;q=0.5, fr, de, en, it, es, pt, no, se, fi, ro', ['nl', 'fr'], 'fr'
            ]
        ];
    }

    /**
     * accept-language, expect
     * @return array
     */
    public function languagesData()
    {
        return [
            [
                null, ['*']
            ],
            [
                '*', ['*']
            ],
            [
                '*, en', ['*', 'en']
            ],
            [
                '*, en;q=0', ['*']
            ],
            [
                '*;q=0.8, en, es', ['en', 'es', '*']
            ],
            [
                'en', ['en']
            ],
            [
                'en;q=0', []
            ],
            [
                'en;q=0.8, es', ['es', 'en']
            ],
            [
                'en;q=0.9, es;q=0.8, en;q=0.7', ['en', 'es']
            ],
            [
                'en-US, en;q=0.8', ['en-US', 'en']
            ],
            [
                'en-US, en-GB', ['en-US', 'en-GB']
            ],
            [
                'en-US;q=0.8, es', ['es', 'en-US']
            ],
            [
                'nl;q=0.5, fr, de, en, it, es, pt, no, se, fi, ro', ['fr', 'de', 'en', 'it', 'es', 'pt', 'no', 'se', 'fi', 'ro', 'nl']
            ]
        ];
    }

    /**
     * accept-language, languages, expect
     * @return array
     */
    public function languagesArrayData()
    {
        return [
            [
                null, ['en'], ['en']
            ],
            [
                null, ['es', 'en'], ['es', 'en']
            ],
            [
                '*', ['en'], ['en']
            ],
            [
                '*', ['es', 'en'], ['es', 'en']
            ],
            [
                '*, en', ['en'], ['en']
            ],
            [
                '*, en', ['es', 'en'], ['en', 'es']
            ],
            [
                '*, en;q=0', ['en'], []
            ],
            [
                '*, en;q=0', ['es', 'en'], ['es']
            ],
            [
                '*;q=0.8, en, es', []
            ]
        ];
    }
}

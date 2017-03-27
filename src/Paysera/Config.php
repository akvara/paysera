<?php
/**
 * Created by PhpStorm.
 * User: andrius
 * Date: 17.3.27
 * Time: 22.24
 */

namespace Paysera;


final class Config
{
    /** Data file delimiter */
    const DELIMITER = ',';

    /** Currencies allowed as well as exchange rates */
    const CURRENCIES = 'curr_rates.csv';

    /** Paysera charges */
    const PRICE_LIST = 'prices.csv';

    /** Compulsory config keys for charges config */
    const PRICE_LIST_KEYS = [
        'IN_COMM_RATE',
        'IN_COMM_MAX',
        'OUT_COMM_RATE_NAT',
        'OUT_LIMIT_NAT',
        'OUT_COMM_OP_NAT',
        'OUT_COMM_RATE_LEG',
        'OUT_MIN_COMM_LEG'
    ];

    /** Config format is: AAA,123.456 */
    const CONFIG_FORMAT = ['String', 'Numeric'];

    /** User data format is: 2016-01-05,1,natural,cash_in,200.00,EUR */
    const USER_DATA_FORMAT = ['Date', 'Numeric', 'String', 'String', 'Numeric', 'String'];

    /** Date format is: Y-m-d */
    const DATE_FORMAT = 'Y-m-d';

    /** Metadata for App Self-check */
    const CONFIG_FILES = [
        self::CURRENCIES => [
            'format' => self::CONFIG_FORMAT
        ],
        self::PRICE_LIST => [
            'format' => self::CONFIG_FORMAT,
            'keys' => self::PRICE_LIST_KEYS
        ]
    ];

    /**
     * Config constructor.
     * @throws \Exception
     */
    private function __construct(){
        throw new \Exception("Can't get an instance of Config");
    }
}
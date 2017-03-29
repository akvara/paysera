<?php
/**
 * User: andrius
 * Date: 17.3.27
 * Time: 22.24
 */

namespace Paysera;

/**
 * Class Config
 * @package Paysera
 */
final class Config
{
    /** Data file delimiter */
    const DELIMITER = ',';

    /** Currencies allowed as well as rounding accuracy */
    const CURRENCIES = 'supported_currencies.csv';

    /** Currency exchange rates */
    const RATES = 'currency_rates.csv';

    /** Paysera charges */
    const TARIFFS = 'tariffs.csv';

    /** Paysera charges */
    const BASE_CURRENCY = 'EUR';

    /** Compulsory config keys for charges config */
    const TARIFFS_KEYS = [
        'IN_RATE',
        'IN_MAX',
        'OUT_RATE_NAT',
        'OUT_LIMIT_SUM_NAT',
        'OUT_LIMIT_OP_NAT',
        'OUT_RATE_LEG',
        'OUT_MIN_LEG'
    ];

    const ENUMS = [
        /** Client types */
        'ClientType' => [
            'private' => 'natural',
            'company' => 'legal'
        ],
        /** Money flow directions */
        'Direction' => [
            'in' => 'cash_in',
            'out' => 'cash_out'
        ]
    ];

    /** Config format is: AAA,123.456 */
    const CONFIG_FORMAT = ['String', 'Numeric'];

    /** User data format is: 2016-01-05,1,natural,cash_in,200.00,EUR */
    const USER_DATA_FORMAT = ['Date', 'Numeric', 'ClientType', 'Direction', 'Numeric', 'Currency'];

    /** Date format is: Y-m-d */
    const DATE_FORMAT = 'Y-m-d';

    /** Metadata for App Self-check */
    const CONFIG_FILES = [
        self::CURRENCIES => [
            'format' => self::CONFIG_FORMAT
        ],
        self::RATES => [
            'format' => self::CONFIG_FORMAT
        ],
        self::TARIFFS => [
            'format' => self::CONFIG_FORMAT,
            'keys' => self::TARIFFS_KEYS
        ]
    ];

    /**
     * Config constructor.
     *
     * @throws \Exception
     */
    private function __construct(){
        throw new \Exception("Can't get an instance of Config");
    }
}

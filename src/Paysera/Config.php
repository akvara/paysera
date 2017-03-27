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
    const DELIMITER = ',';

    const CURRENCIES = 'curr_rates.csv';
    const PRICE_LIST = 'prices.csv';

    const CONFIG_FORMAT = ['String', 'Numeric'];
    const DATA_FORMAT = ['String', 'Numeric'];

    const CONFIG_FILES = [
        self::CURRENCIES => self::CONFIG_FORMAT,
        self::PRICE_LIST => self::CONFIG_FORMAT
    ];

    private function __construct(){
        throw new \Exception("Can't get an instance of Config");
    }
}
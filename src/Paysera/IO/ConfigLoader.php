<?php
/**
 * Created by PhpStorm.
 * User: andrius
 * Date: 17.3.28
 * Time: 04.40
 */

namespace Paysera\IO;


use Paysera\Config;

/**
 * Class ConfigLoader
 * @package Paysera\ConfigLoader
 */
class ConfigLoader
{

    /**
     * Loads config file and returns as array
     *
     * @param $fileName
     * @return array
     */
    static public function loadConfig($fileName)
    {
        $handle = (new FileReader($fileName))->getHandle();
        $config = [];

        while (($data = fgetcsv($handle, 0, Config::DELIMITER)) !== FALSE) {
            $val = strpos($data[1], '.') ? floatval($data[1]) : intval($data[1]);
            $config[$data[0]] = $val;
        }

        return $config;
    }

}
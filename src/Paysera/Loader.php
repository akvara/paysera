<?php
/**
 * Created by PhpStorm.
 * User: andrius
 * Date: 17.3.28
 * Time: 04.40
 */

namespace Paysera;


class Loader
{
    static public function loadConfig($fileName)
    {
        $handle = (new FileReader($fileName))->getHandle();
        $config = [];
        while (($data = fgetcsv($handle, 0, Config::DELIMITER)) !== FALSE) {
            $config[] = $data;
        }

        return $config;
    }
}
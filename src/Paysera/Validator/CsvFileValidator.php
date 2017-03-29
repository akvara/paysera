<?php

namespace Paysera\Validator;


use Paysera\Config;
use Paysera\IO\FileReader;

/**
 * Class CsvFileValidator
 * @package Paysera\Validator
 */
class CsvFileValidator
{
    /**
     * @var array
     */
    private $currencies = [];
    /**
     * @param $fileName
     * @param array $fileSpec
     */
    public function validateFile($fileName, array $fileSpec)
    {
        $handle = (new FileReader($fileName))->getHandle();

        $row = 0;
        $keys = [];

        while (($data = fgetcsv($handle, 0, Config::DELIMITER)) !== FALSE) {
            $row++;
            $keys[] = $data[0];
            $this->checkColumnCount($data, $fileSpec['format'], $fileName, $row);
            $this->checkColumnTypes($data, $fileSpec['format'], $fileName, $row);
        }

        if (isset($fileSpec['keys'])) {
            $this->checkKeys($keys, $fileSpec['keys'], $fileName);
        }
    }

    /**
     * Checks if column count corresponds to requiredh
     *
     * @param $data
     * @param $format
     * @param $fileName
     * @param $row
     * @throws \Exception
     */
    private function checkColumnCount($data, $format, $fileName, $row)
    {
        $num = count($data);

        if ($num != count($format)) {
            $err = sprintf(
                "Unexpected number of columns, file %s, line %d: expected %d, found %d",
                $fileName,
                $row,
                count($format),
                $num
            );

            throw new \Exception($err);
        }
    }

    /**
     * Checks if column types correspond to required
     *
     * @param $data
     * @param $format
     * @param $fileName
     * @param $row
     * @throws \Exception
     */
    private function checkColumnTypes($data, $format, $fileName, $row)
    {
        $num = count($data);

        for ($column=0; $column < $num; $column++) {
            switch ($format[$column]) {
                case 'String':
                    break;
                case 'Numeric':
                    if (!is_numeric($data[$column])) {
                        $err = sprintf(
                            "Unexpected type of column, file %s, line %d, column %d: expected Number",
                            $fileName,
                            $row,
                            $column + 1
                        );

                        throw new \Exception($err);
                    }
                    break;
                case 'Date':
                    if (!$this->validateDate($data[$column])) {
                        $err = sprintf(
                            "Incorrect date in file %s, line %d column %d",
                            $fileName,
                            $row,
                            $column + 1
                        );

                        throw new \Exception($err);
                    }
                    break;
                case 'Currency':
                    if (!$this->validateCurrency($data[$column])) {
                        $err = sprintf(
                            "Incorrect currency %s in file %s, line %d column %d",
                            $data[$column],
                            $fileName,
                            $row,
                            $column + 1
                        );

                        throw new \Exception($err);
                    }
                    break;
                case in_array($format[$column], array_keys(Config::ENUMS)):
                    if (!$this->validateEnum(Config::ENUMS[$format[$column]], $data[$column])) {
                        $err = sprintf(
                            "Invalid value in file %s, line %d column %d",
                            $fileName,
                            $row,
                            $column + 1
                        );
                        throw new \Exception($err);
                    }
                    break;
            }
        }
    }

    /**
     * Validates date
     *
     * @param $date
     * @return bool
     */
    function validateDate($date)
    {
        $testDate = \DateTime::createFromFormat(Config::DATE_FORMAT, $date);
        return $testDate && $testDate->format(Config::DATE_FORMAT) === $date;
    }

    /**
     * Validates ENUM
     *
     * @param $enum
     * @param $data
     * @return bool
     */
    function validateEnum($enum, $data)
    {
        return in_array($data, $enum);
    }

    /**
     * Validates currency
     *
     * @param $data
     * @return bool
     */
    function validateCurrency($data)
    {
        return in_array($data, $this->currencies);
    }

    /**
     * Checks if all required configurations keys are set
     *
     * @param $keys
     * @param $required
     * @param $fileName
     * @throws \Exception
     */
    private function checkKeys($keys, $required, $fileName)
    {
        foreach ($required as $key) {
            if (!in_array($key, $keys)) {
                $err = sprintf(
                    "Missing key %s in config file %s",
                    $key,
                    $fileName
                );

                throw new \Exception($err);
            }
        }
    }

    /**
     * Setter for currencies
     *
     * @param array $currencies
     * @return CsvFileValidator
     */
    public function setCurrencies($currencies)
    {
        $this->currencies = $currencies;
        return $this;
    }
}

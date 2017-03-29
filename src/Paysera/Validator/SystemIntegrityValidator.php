<?php

namespace Paysera\Validator;

use Paysera\Config;

/**
 * Class SystemIntegrityValidator
 * @package Paysera\Validator
 */
class SystemIntegrityValidator
{
    /** @var  array */
    private $currencies;

    /** @var array */
    private $rates;

    /**
     * SystemIntegrityValidator constructor.
     *
     * @param array $currencies
     * @param array $rates
     */
    public function __construct(array $currencies, array $rates)
    {
        $this->currencies = $currencies;
        $this->rates = $rates;
    }

    /**
     * Validates system integrity
     */
    public function validate()
    {
        $validator = new CsvFileValidator($this->currencies);

        foreach (Config::CONFIG_FILES as $fileName => $fileSpec) {
            $validator->validateFile($fileName, $fileSpec);
        }

        $this->checkCurrencyRates($this->currencies, $this->rates);

        return true;
    }

    /**
     * Checks if all supported currencies have rates set
     *
     * @param array $currencies
     * @param array $rates
     * @throws \Exception
     */
    private function checkCurrencyRates(array $currencies, array $rates)
    {
        foreach ($currencies as $currency => $accuracy) {
            if (!in_array($currency, array_keys($rates))) {
                throw new \Exception('Missing currency rate ' . $currency);
            }
        }
    }
}

<?php

namespace Paysera\Validator;

use Paysera\Config;

class UserDataValidator
{
    /** @var  array */
    private $currencies;

    /** @var  string */
    private $userFile;

    /**
     * UserDataValidator constructor.
     *
     * @param array $currencies
     */
    public function __construct($currencies, $userFile)
    {
        $this->currencies = $currencies;
        $this->userFile = $userFile;
    }

    /**
     * Validates user data
     */
    public function validate()
    {
        $validator = new CsvFileValidator($this->currencies);

        $validator->validateFile($this->userFile, ['format' => Config::USER_DATA_FORMAT]);
    }
}

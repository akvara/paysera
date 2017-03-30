<?php

namespace Paysera\IO;

use Paysera\Entity\Money;

/**
 * Class Formatter
 * @package Paysera\IO
 */
class Formatter
{
    /** @var array */
    private $currencyAccuracy;

    /**
     * Formatter constructor.
     * 
     * @param array $currencyAccuracy
     */
    public function __construct(array $currencyAccuracy)
    {
        $this->currencyAccuracy = $currencyAccuracy;
    }

    /**
     * Rounds according to The Rules
     *
     * @param Money $money
     * @return string
     */
    public function roundedPrint(Money $money)
    {
        $accuracy = $this->currencyAccuracy[$money->getCurrency()];

        $value = ceil($money->getAmount() / $accuracy) * $accuracy;

        if($accuracy >= 1) return sprintf("%01d", $value);

        return sprintf("%01.2f", $value);
    }
}

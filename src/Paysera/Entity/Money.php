<?php

namespace Paysera\Entity;

/**
 * Class Money
 * @package Paysera\Entity
 */
class Money
{
    /** @var float */
    private $amount;

    /** @var string */
    private $currency;

    /**
     * Money constructor.
     *
     * @param float $amount
     * @param string $currency
     */
    public function __construct($amount, $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * Getter for amount
     *
     * @return float
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Getter for currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Calculates amount corresponding sum in other currency
     *
     * @param $foreignCurrency
     * @param $rates
     * @return float
     */
    public function amountIn($foreignCurrency, $rates)
    {
        return $this->amount / $rates[$this->currency] * $rates[$foreignCurrency];
    }

    /**
     * Compares this Money to another
     *
     * @param Money $comparedTo
     * @param array $rates
     * @return bool
     */
    public function isMore(Money $comparedTo, array $rates)
    {
        return $this->amount > $comparedTo->amountIn($this->getCurrency(), $rates);
    }

    /**
     * Rounds according to The Rules
     *
     * @param $currencies
     * @return float
     */
    public function roundedPrint($currencies)
    {
        $accuracy = $currencies[$this->getCurrency()];
        $value = ceil($this->amount / $accuracy) * $accuracy;

        if($accuracy >= 1) return sprintf("%01d", $value);

        return sprintf("%01.2f", $value);
    }

    /**
     * Deducts given sum in base currency from this. No negative sums.
     *
     * @param $sumInBaseCurr
     * @param array $rates
     * @return Money
     */
    public function deductInBaseCurr($sumInBaseCurr, $rates)
    {
        $sum = $sumInBaseCurr * $rates[$this->currency];

        if ($sum >  $this->amount) {
            return new Money(0, $this->currency);
        }

        return new Money($this->amount - $sum, $this->currency);
    }

    /**
     * Returns money multiplicated by given factor
     *
     * @param $factor
     * @return Money
     */
    public function multipliedBy($factor)
    {
        return new Money($this->amount * $factor, $this->currency);
    }
}

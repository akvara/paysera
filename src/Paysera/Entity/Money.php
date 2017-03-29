<?php

namespace Paysera\Entity;


/**
 * Class Money
 * @package Paysera\Entity
 */
class Money
{
    /** @var double */
    private $amount;

    /** @var string */
    private $currency;

    /**
     * Money constructor.
     *
     * @param double $amount
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
     * @return double
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
     * @return double
     */
    public function amountIn($foreignCurrency, $rates)
    {
        return $this->amount / $rates[$this->currency] * $rates[$foreignCurrency];
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
    public function rounded($currencies)
    {
        $accuracy = $currencies[$this->getCurrency()];

        return ceil($this->amount / $accuracy) * $accuracy;
    }
}

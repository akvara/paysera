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
}

<?php

namespace Paysera;

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
//var_dump("construct:" , $amount, $currency) ;
        $this->amount = $amount;
        $this->currency = $currency;
    }

    /**
     * @return double
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param $foreignCurrency
     * @param $rates
     * @return double
     */
    public function amountIn($foreignCurrency, $rates)
    {
        return $this->amount * $rates[$foreignCurrency];
    }

    public function multiply($factor)
    {
        return new Money($this->amount * $factor, $this->currency);
    }

    public function isMore(Money $comparedTo, array $rates)
    {
        return $this->amount > $comparedTo->amountIn($this->getCurrency(), $rates);
    }
}

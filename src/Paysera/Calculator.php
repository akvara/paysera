<?php

namespace Paysera;

class Calculator
{
    const BASE_CURRENCY = 'EUR';

    /** @var array */
    private $tariffs;

    /** @var array */
    private $rates;

    /**
     * Calculator constructor.
     *
     * @param array $tariffs
     * @param array $rates
     */
    public function __construct(array $tariffs, array $rates)
    {
        $this->tariffs = $tariffs;
        $this->rates = $rates;
    }

    public function calculate($currency, $sum, $clientType, $direction)
    {
        if ($direction === Config::ENUMS['Direction']['in']) return $this->calculateInBound($sum);
        return $this->calculateOutBound($sum, $clientType);
    }

    private function calculateInBound($sum)
    {
        $comm = $sum * $this->tariffs['IN_RATE'];
        if ($this->inBaseCurrency($comm) > $this->tariffs['IN_RATE']) {return $comm;}
        return $comm;
    }

    private function calculateOutBound($clientType)
    {
        if ($clientType === Config::ENUMS['ClientType']['private']) return $this->calculateForPrivate();
        return $this->CalculateForCompany();
    }

    /**
     * Calculates sum in Base Currency
     *
     * @param string $currency
     * @param float $sum
     * @return float
     */
    private function inBaseCurrency($currency, $sum)
    {
        if ($currency === self::BASE_CURRENCY) return $sum;
        return $sum / $this->rates[$currency];
    }

    /**
     * Calculates sum in Foreign Currency
     *
     * @param string $currency
     * @param float $sum
     * @return float
     */
    private function inForeignCurrency($currency, $sum)
    {
        if ($currency === self::BASE_CURRENCY) return $sum;
        return $sum * $this->rates[$currency];
    }
}

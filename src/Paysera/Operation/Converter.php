<?php

namespace Paysera\Operation;

/**
 * Class Converter
 * @package Paysera\Operation
 */
use Paysera\Entity\Money;

/**
 * Class Converter
 * @package Paysera\Operation
 */
class Converter
{
    /** @var array */
    private $currencyRates;

    /**
     * Converter constructor.
     *
     * @param array $currencyRates
     */
    public function __construct(array $currencyRates)
    {
        $this->currencyRates = $currencyRates;
    }

    /**
     * Converts one currency to another
     *
     * @param Money $money
     * @param string $currency
     * @return Money
     */
    public function convert(Money $money, $currency)
    {
        $amount =
            $money->getAmount() / $this->currencyRates[$money->getCurrency()] * $this->currencyRates[$currency];

        return new Money($amount, $currency);
    }

    /**
     * Compares money2 from money1
     *
     * @param Money $money1
     * @param Money $money2
     * @return int
     */
    public function compare(Money $money1, Money $money2)
    {
        $money2AmountConvertedToMoney1Currency =
                $this->convert($money2, $money1->getCurrency())->getAmount();

        if ($money1->getAmount() === $money2AmountConvertedToMoney1Currency) return 0;

        if ($money1->getAmount() < $money2AmountConvertedToMoney1Currency) return -1;

        return 1;
    }

    /**
     * Subtracts money2 from money1
     *
     * @param Money $money1
     * @param Money $money2
     * @return Money
     */
    public function subtract(Money $money1, Money $money2)
    {
        $money2AmountConvertedToMoney1Currency =
            $this->convert($money2, $money1->getCurrency())->getAmount();

        return new Money(
            $money1->getAmount() - $money2AmountConvertedToMoney1Currency,
            $money1->getCurrency()
        );
    }

    /**
     * Returns money multiplicated by given factor
     *
     * @param $factor
     * @return Money
     */
    public function multipliedBy(Money $money1, $factor)
    {
        return new Money($money1->getAmount() * $factor, $money1->getCurrency());
    }
}

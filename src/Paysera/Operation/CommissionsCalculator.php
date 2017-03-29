<?php

namespace Paysera\Operation;
use Paysera\Config;
use Paysera\Entity\Money;

/**
 * Class CommissionsCalculator
 * @package Paysera\Operation
 */
class CommissionsCalculator
{
    /**
     * Returns commissions for cashing in for private client
     *
     * @param Money $money
     * @param array $tariffs
     * @param array $rates
     * @return Money
     */
    static public function commissionsCashInPrivate(Money $money, array $tariffs, array $rates)
    {
        $upperLimit = new Money($tariffs['IN_MAX'], Config::BASE_CURRENCY);

        $comm = $money->multipliedBy($tariffs['IN_RATE'] / 100);

        if ($comm->isMore($upperLimit, $rates)) {
            return new Money(
                $upperLimit->amountIn($comm->getCurrency(), $rates),
                $money->getCurrency()
            );
        }

        return $comm;
    }

    /**
     * Returns commissions for cashing out for private client
     *
     * @param Money $money
     * @param $countOfWithdrThisWeek
     * @param $sumOfWithdrThisWeek
     * @param array $tariffs
     * @param array $rates
     * @return Money
     */
    static public function commissionsCashOutPrivate(
        Money $money,
        $countOfWithdrThisWeek,
        $sumOfWithdrThisWeek,
        array $tariffs,
        array $rates
    ) {
        if ($countOfWithdrThisWeek > $tariffs['OUT_LIMIT_OP_NAT']) {
            return $money->multipliedBy($tariffs['OUT_RATE_NAT'] / 100);
        }

        $commissionFreeSumInBaseCurr = $tariffs['OUT_LIMIT_SUM_NAT'] - $sumOfWithdrThisWeek;
        $taxable = $money->deductInBaseCurr($commissionFreeSumInBaseCurr, $rates);

        return new Money($taxable->getAmount() * $tariffs['OUT_RATE_NAT'] / 100, $money->getCurrency());
    }

    /**
     * Returns commissions for cashing in for company/legal
     *
     * @param Money $money
     * @param array $tariffs
     * @param array $rates
     * @return Money
     */
    static public function commissionsCashInCompany(Money $money, array $tariffs, array $rates)
    {
        return self::commissionsCashInPrivate($money, $tariffs, $rates);
    }

    /**
     * Returns commissions for cashing out for company/legal
     *
     * @param Money $money
     * @param array $tariffs
     * @param array $rates
     * @return Money
     */
    static public function commissionsCashOutCompany(Money $money, array $tariffs, array $rates)
    {
        $lowerLimit = new Money($tariffs['OUT_MIN_LEG'], Config::BASE_CURRENCY);
        $comm = $money->multipliedBy($tariffs['OUT_RATE_LEG'] / 100);

        if ($lowerLimit->isMore($comm, $rates)) {
            return new Money(
                $lowerLimit->amountIn($comm->getCurrency(), $rates),
                $money->getCurrency()
            );
        }

        return $comm;
    }
}

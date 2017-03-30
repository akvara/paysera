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
        $converter = new Converter($rates);

        $upperLimit = new Money($tariffs['IN_MAX'], Config::BASE_CURRENCY);

        $comm = $converter->multipliedBy($money, $tariffs['IN_RATE'] / 100);

        if ($converter->compare($comm, $upperLimit) === 1) {
            $comm = $converter->convert($upperLimit, $money->getCurrency());
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
        $converter = new Converter($rates);

        if ($countOfWithdrThisWeek > $tariffs['OUT_LIMIT_OP_NAT']) {
            return $converter->multipliedBy($money, $tariffs['OUT_RATE_NAT'] / 100);
        }

        $taxable = $money;
        $commissionFree = $converter->subtract(
            new Money($tariffs['OUT_LIMIT_SUM_NAT'], Config::BASE_CURRENCY),
            new Money($sumOfWithdrThisWeek, Config::BASE_CURRENCY)
        );

        if ($commissionFree->getAmount() > 0) {
            $taxable = $converter->subtract($money, $commissionFree);
            if ($taxable->getAmount() < 0) $taxable = new Money(0, $money->getCurrency());
        }

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

        $converter = new Converter($rates);

        $comm = $converter->multipliedBy($money, $tariffs['OUT_RATE_LEG'] / 100);

        if ($converter->compare($lowerLimit, $comm) === 1) {
            return $converter->convert($lowerLimit, $money->getCurrency());
        }

        return $comm;
    }
}

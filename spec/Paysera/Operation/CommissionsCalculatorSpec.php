<?php

namespace spec\Paysera\Operation;

use Paysera\Operation\CommissionsCalculator;
use Paysera\Entity\Money;
use PhpSpec\ObjectBehavior;

/**
 * Class commissionsCalculatorSpec
 * @package spec\Paysera\Operation
 */
class CommissionsCalculatorSpec extends ObjectBehavior
{
    const TEST_TARIFFS = [
        'IN_RATE'           => 0.03,
        'IN_MAX'            => 5,
        'OUT_RATE_NAT'      => 0.3,
        'OUT_LIMIT_SUM_NAT' => 1000,
        'OUT_LIMIT_OP_NAT'  => 3,
        'OUT_RATE_LEG'      => 0.3,
        'OUT_MIN_LEG'       => 0.5
    ];

    const TEST_RATES = [
        'EUR' => 1,
        'FOR' => 1.5
    ];
    
    const TEST_BASE_CURRENCY = "EUR";

    function it_is_initializable()
    {
        $this->shouldHaveType(CommissionsCalculator::class);
    }

    // *** Private - In ***
    function it_should_calc_default_cash_in_commissions_for_private()
    {
        $this
            ->commissionsCashInPrivate(
                new Money(100, 'FOR'),
                self::TEST_TARIFFS,
                self::TEST_RATES
            )
            ->getAmount()
            ->shouldBe(100 * self::TEST_TARIFFS['IN_RATE'] / 100);
    }

    function it_should_not_exceed_max_in_commission_for_private()
    {
        $max = new Money(self::TEST_TARIFFS['IN_MAX'], self::TEST_BASE_CURRENCY);

        $this
            ->commissionsCashInPrivate(
                new Money(100000, 'FOR'),
                self::TEST_TARIFFS,
                self::TEST_RATES
            )
            ->getAmount()
            ->shouldBe($max->amountIn('FOR', self::TEST_RATES));
    }

    // *** Private - Out ***

    function it_should_apply_default_rate_for_exceeded_number_of_withdr_for_private()
    {
        $this
            ->commissionsCashOutPrivate(
                new Money(100, 'FOR'),
                self::TEST_TARIFFS['OUT_LIMIT_OP_NAT'] + 1,
                1.00,
                self::TEST_TARIFFS,
                self::TEST_RATES
            )
            ->getAmount()
            ->shouldBe(100 * self::TEST_TARIFFS['OUT_RATE_NAT'] / 100);
    }

    function it_should_respect_allowed_free_limit_per_week_for_private()
    {
        $limit = new Money(self::TEST_TARIFFS['OUT_LIMIT_SUM_NAT'], self::TEST_BASE_CURRENCY);

        $takingOut = new Money(5000, 'FOR');

        $expectingToPayCommFrom = $takingOut->getAmount() - $limit->amountIn('FOR', self::TEST_RATES);

        $this
            ->commissionsCashOutPrivate(
                $takingOut,
                0,
                0,
                self::TEST_TARIFFS,
                self::TEST_RATES
            )
            ->getAmount()
            ->shouldBe($expectingToPayCommFrom * self::TEST_TARIFFS['OUT_RATE_NAT'] / 100);
    }

    function it_should_deduct_used_limit_of_per_week_for_private()
    {
        $limit = new Money(self::TEST_TARIFFS['OUT_LIMIT_SUM_NAT'], self::TEST_BASE_CURRENCY);
        $used = new Money(500, self::TEST_BASE_CURRENCY);

        $takingOut = new Money(5000, 'FOR');

        $expectingToPayCommFrom =
            $takingOut->getAmount()
            - $limit->amountIn('FOR', self::TEST_RATES)
            + $used->amountIn('FOR', self::TEST_RATES);

        $this
            ->commissionsCashOutPrivate(
                $takingOut,
                1,
                $used->getAmount(),
                self::TEST_TARIFFS,
                self::TEST_RATES
            )
            ->getAmount()
            ->shouldBe($expectingToPayCommFrom * self::TEST_TARIFFS['OUT_RATE_NAT'] / 100);
    }

    // *** Company - In ***

    function it_should_calc_default_cash_in_commissions_for_company()
    {
        $this
            ->commissionsCashInCompany(
                new Money(100, 'FOR'),
                self::TEST_TARIFFS,
                self::TEST_RATES
            )
            ->getAmount()
            ->shouldBe(100 * self::TEST_TARIFFS['IN_RATE'] / 100);
    }

    function it_should_not_exceed_max_cash_in_commission_for_company()
    {
        $max = new Money(self::TEST_TARIFFS['IN_MAX'], self::TEST_BASE_CURRENCY);

        $this
            ->commissionsCashInCompany(
                new Money(100000, 'FOR'),
                self::TEST_TARIFFS,
                self::TEST_RATES
            )
            ->getAmount()
            ->shouldBe($max->amountIn('FOR', self::TEST_RATES));
    }

    // *** Company - Out ***

    function it_should_calc_default_cash_out_for_companies()
    {
        $this
            ->commissionsCashOutCompany(
                new Money(10000, 'FOR'),
                self::TEST_TARIFFS,
                self::TEST_RATES
            )
            ->getAmount()
            ->shouldBe(10000 * self::TEST_TARIFFS['OUT_RATE_LEG'] / 100);
    }

    function it_should_not_be_less_than_min_cash_out_for_companies()
    {
        $min = new Money(self::TEST_TARIFFS['OUT_MIN_LEG'], self::TEST_BASE_CURRENCY);

        $this
            ->commissionsCashOutCompany(
                new Money(1, 'FOR'),
                self::TEST_TARIFFS,
                self::TEST_RATES
            )
            ->getAmount()
            ->shouldBe($min->amountIn('FOR', self::TEST_RATES));
    }
}

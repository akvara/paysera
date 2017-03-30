<?php

namespace spec\Paysera\Operation;

use Paysera\Entity\Money;
use Paysera\Operation\Transactor;
use PhpSpec\ObjectBehavior;

/**
 * Class TransactorSpec
 * @package spec\Paysera\Operation
 */
class TransactorSpec extends ObjectBehavior
{
    const TEST_CURRENCIES = [
        'EUR' => 0.01,
        'USD' => 0.01,
        'JPY' => 1
    ];

    const TEST_RATES = [
        'EUR' => 1,
        'USD' => 1.1497,
        'JPY' => 129.53
    ];

    const TEST_TARIFFS = [
        'IN_RATE'           => 0.03,
        'IN_MAX'            => 5,
        'OUT_RATE_NAT'      => 0.3,
        'OUT_LIMIT_SUM_NAT' => 1000,
        'OUT_LIMIT_OP_NAT'  => 3,
        'OUT_RATE_LEG'      => 0.3,
        'OUT_MIN_LEG'       => 0.5
    ];

    function let()
    {
        $this->beConstructedWith(self::TEST_CURRENCIES, self::TEST_RATES, self::TEST_TARIFFS);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Transactor::class);
    }

    function it_should_return_0_on_0_sum_private_cash_in()
    {
        $this
            ->process(new \DateTime(), 1, 'natural', 'cash_in', new Money(0, 'EUR'))
            ->getAmount()
            ->shouldEqual(0.00);
    }

    function it_should_return_0_on_0_sum_private_cash_out()
    {
        $this
            ->process(new \DateTime(), 1, 'natural', 'cash_out', new Money(0, 'EUR'))
            ->getAmount()
            ->shouldEqual(0.00);
    }

    function it_should_return_0_on_0_sum_company_cash_in()
    {
        $this
            ->process(new \DateTime(), 1, 'legal', 'cash_in', new Money(0, 'EUR'))
            ->getAmount()
            ->shouldEqual(0.00);
    }

    function it_should_return_MIN_on_0_sum_company_cash_out()
    {
        $this
            ->process(new \DateTime(), 1, 'legal', 'cash_out', new Money(0, 'EUR'))
            ->getAmount()
            ->shouldEqual(self::TEST_TARIFFS['OUT_MIN_LEG']);
    }
}

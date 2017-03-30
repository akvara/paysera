<?php

namespace spec\Paysera\Entity;

use Paysera\Entity\Money;
use PhpSpec\ObjectBehavior;

/**
 * Class MoneySpec
 * @package spec\Paysera\Entity
 */
class MoneySpec extends ObjectBehavior
{
    const TEST_CURRENCIES = [
        'EUR' => 0.01,
        'FOR' => 1
    ];

    const TEST_RATES = [
        'EUR' => 1,
        'FOR' => 1.5,
        'ANO' => 0.5
    ];

    function it_is_initializable()
    {
        $this->beConstructedWith(5.23, 'EUR');
        $this->shouldHaveType(Money::class);
    }

    function it_can_calculate_itself_to_foreign_currency_case1()
    {
        $this->beConstructedWith(8, 'EUR');
        $this->amountIn('FOR', self::TEST_RATES)->shouldBe(8 * 1.5);
    }

    function it_can_calculate_itself_to_foreign_currency_case2()
    {
        $this->beConstructedWith(8, 'FOR');
        $this->amountIn('EUR', self::TEST_RATES)->shouldBe(8 / 1.5);
    }

    function it_can_calculate_itself_to_foreign_currency_case3()
    {
        $this->beConstructedWith(8, 'ANO');
        $this->amountIn('FOR', self::TEST_RATES)->shouldBe(8 / 0.5 * 1.5);
    }

    function it_can_estimate_if_is_more()
    {
        $comparedTo = new Money(4, 'FOR');
        $this->beConstructedWith(8, 'EUR');
        $this->isMore($comparedTo, self::TEST_RATES)->shouldBe(true);
    }

    function it_can_deduct_sum_in_other_currency()
    {
        $this->beConstructedWith(1000, 'FOR');
        $this
            ->deductInBaseCurr(500, self::TEST_RATES)
            ->getAmount()
            ->shouldBe(250.00);
    }
}

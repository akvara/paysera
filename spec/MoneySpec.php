<?php

namespace spec\Paysera;

use Paysera\Money;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MoneySpec extends ObjectBehavior
{
    const RATES = [
        'EUR' => 1,
        'FOR' => 1.5
    ];

    function it_is_initializable()
    {
        $this->beConstructedWith(5.23, 'EUR');
        $this->shouldHaveType(Money::class);
    }

    function it_can_calculate_itself_to_foreign_currency()
    {
        $this->beConstructedWith(8, 'EUR');
        $this->amountIn('FOR', self::RATES)->shouldBe(8 * 1.5);
    }

    function it_can_estimate_if_is_more()
    {
        $comparedTo = new Money(4, 'FOR');
        $this->beConstructedWith(8, 'EUR');
        $this->isMore($comparedTo, self::RATES)->shouldBe(true);
    }
}

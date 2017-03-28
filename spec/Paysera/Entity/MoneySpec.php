<?php

namespace spec\Paysera\Entity;

use Paysera\Entity\Money;
use PhpSpec\ObjectBehavior;

/**
 * Class MoneySpec
 * @package spec\Paysera
 */
class MoneySpec extends ObjectBehavior
{
    const TEST_CURRENCIES = [
        'EUR' => 0.01,
        'FOR' => 1
    ];

    const TEST_RATES = [
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
        $this->amountIn('FOR', self::TEST_RATES)->shouldBe(8 * 1.5);
    }

    function it_can_estimate_if_is_more()
    {
        $comparedTo = new Money(4, 'FOR');
        $this->beConstructedWith(8, 'EUR');
        $this->isMore($comparedTo, self::TEST_RATES)->shouldBe(true);
    }

    function it_can_round_itself_up_with_cents()
    {
        $this->beConstructedWith(4.023, 'EUR');
        $this->rounded(self::TEST_CURRENCIES)->shouldBe(4.03);
    }

    function it_can_round_itself_up_without_cents()
    {
        $this->beConstructedWith(4.023, 'FOR');
        $this->rounded(self::TEST_CURRENCIES)->shouldBe(5.00);
    }
}

<?php

namespace spec\Paysera\IO;

use Paysera\Entity\Money;
use Paysera\IO\Formatter;
use PhpSpec\ObjectBehavior;

class FormatterSpec extends ObjectBehavior
{
    const TEST_CURRENCIES = [
        'EUR' => 0.01,
        'FOR' => 1
    ];

    function let()
    {
        $this->beConstructedWith(self::TEST_CURRENCIES);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Formatter::class);
    }

    function it_can_round_up_currency_with_cents()
    {
        $money = new Money(4.023, 'EUR');
        $this->beConstructedWith(self::TEST_CURRENCIES);
        $this->roundedPrint($money)->shouldBe("4.03");
    }

    function it_can_round_up_currency_without_cents()
    {
        $money = new Money(4.023, 'FOR');
        $this->beConstructedWith(self::TEST_CURRENCIES);
        $this->roundedPrint($money)->shouldBe("5");
    }
}

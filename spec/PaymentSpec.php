<?php

namespace spec\Paysera;

use Paysera\Config;
use Paysera\Money;
use Paysera\Payment;
use PhpSpec\ObjectBehavior;

class PaymentSpec extends ObjectBehavior
{
    const TEST_TARIFFS = [
        'IN_RATE'       => 0.03,
        'IN_MAX'        => 5,
        'OUT_RATE_NAT'  => 0.3,
        'OUT_LIMIT_NAT' => 1000,
        'OUT_OP_NAT'    => 3,
        'OUT_RATE_LEG'  => 0.3,
        'OUT_MIN_LEG'   => 0.5
    ];

    const TEST_RATES = [
        'EUR' => 1,
        'FOR' => 1.5
    ];

    function it_is_initializable()
    {
        $this->beConstructedWith(new Money(5000.23, 'EUR'), 'cash_in', 'natural');
        $this->shouldHaveType(Payment::class);
    }

    function it_should_throw_exception_on_incorrect_client_type()
    {
        $this
            ->shouldThrow(new \Exception('Illegal client type.'))
            ->during('__construct', [new Money(5.23, 'EUR'), 'cash_out', 'woman']);
    }

    function it_should_throw_exception_on_incorrect_direction()
    {
        $this
            ->shouldThrow(new \Exception('Illegal direction.'))
            ->during('__construct', [new Money(5.23, 'EUR'), 'cash_lost', 'natural']);
    }

    function it_should_calc_direction_in_rate()
    {
        $this->beConstructedWith(new Money(10, 'FOR'), 'cash_in', 'natural');

        $this
            ->commision(self::TEST_TARIFFS, self::TEST_RATES)
            ->getAmount()
            ->shouldBe(10 * self::TEST_TARIFFS['IN_RATE']);
    }

    function it_should_not_exceed_max_in_commision()
    {
        $max = new Money(self::TEST_TARIFFS['IN_MAX'], Config::BASE_CURRENCY);

        $this->beConstructedWith(new Money(100000, 'FOR'), 'cash_in', 'natural');

        $this
            ->commision(self::TEST_TARIFFS, self::TEST_RATES)
            ->getAmount()
            ->shouldBe($max->amountIn('FOR', self::TEST_RATES));
    }
}

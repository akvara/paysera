<?php

namespace spec\Paysera;

use Paysera\Calculator;
use PhpSpec\ObjectBehavior;

class CalculatorSpec extends ObjectBehavior
{
    const TARIFFS = [
        'IN_RATE'       => 0.03,
        'IN_MAX'        => 5,
        'OUT_RATE_NAT'  => 0.3,
        'OUT_LIMIT_NAT' => 1000,
        'OUT_OP_NAT'    => 3,
        'OUT_RATE_LEG'  => 0.3,
        'OUT_MIN_LEG'   => 0.5
    ];

    const RATES = [
        'EUR' => 1,
        'FOR' => 1.5
    ];

    function let() {
        $this->beConstructedWith(self::TARIFFS, self::RATES);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Calculator::class);
    }

    function it_should_calc_correct_inbound()
    {
        $this->shouldHaveType(Calculator::class);
    }
}
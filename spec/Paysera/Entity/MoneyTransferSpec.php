<?php

namespace spec\Paysera\Entity;

use Paysera\Config;
use Paysera\Entity\Money;
use Paysera\Entity\MoneyTransfer;
use PhpSpec\ObjectBehavior;

/**
 * Class MoneyTransferSpec
 * @package spec\Paysera
 */
class MoneyTransferSpec extends ObjectBehavior
{
    const TEST_TARIFFS = [
        'IN_RATE'       => 0.03,
        'IN_MAX'        => 5,
        'OUT_RATE_NAT'  => 0.3,
        'OUT_LIMIT_SUM_NAT' => 1000,
        'OUT_LIMIT_OP_NAT'    => 3,
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
        $this->shouldHaveType(MoneyTransfer::class);
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
}

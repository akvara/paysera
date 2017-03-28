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

    function it_should_calc_direction_in_rate()
    {
        $this->beConstructedWith(new Money(100, 'FOR'), 'cash_in', 'natural');

        $this
            ->commision(self::TEST_TARIFFS, self::TEST_RATES)
            ->getAmount()
            ->shouldBe(100 * self::TEST_TARIFFS['IN_RATE'] / 100);
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

    function it_should_calc_direction_out_for_companies()
    {
        $this->beConstructedWith(new Money(10000, 'FOR'), 'cash_out', 'legal');

        $this
            ->commision(self::TEST_TARIFFS, self::TEST_RATES)
            ->getAmount()
            ->shouldBe(10000 * self::TEST_TARIFFS['OUT_RATE_LEG'] / 100);
    }

    function it_should_not_be_less_than_min_for_companies()
    {
        $min = new Money(self::TEST_TARIFFS['OUT_MIN_LEG'], Config::BASE_CURRENCY);

        $this->beConstructedWith(new Money(1, 'FOR'), 'cash_out', 'legal');

        $this
            ->commision(self::TEST_TARIFFS, self::TEST_RATES)
            ->getAmount()
            ->shouldBe($min->amountIn('FOR', self::TEST_RATES));
    }
}

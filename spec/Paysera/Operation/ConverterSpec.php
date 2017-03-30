<?php

namespace spec\Paysera\Operation;

use Paysera\Entity\Money;
use Paysera\Operation\Converter;
use PhpSpec\ObjectBehavior;

/**
 * Class ConverterSpec
 * @package spec\Paysera\Operation
 */
class ConverterSpec extends ObjectBehavior
{
    const TEST_RATES = [
        'EUR' => 1,
        'USD' => 1.5,
        'JPY' => 129.53
    ];

    function let()
    {
        $this->beConstructedWith(self::TEST_RATES);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Converter::class);
    }

    function it_can_convert_one_currency_to_another()
    {
        $money = new Money(10.10, 'EUR');

        $this->convert($money, 'USD')->getAmount()->shouldReturnApproximately(15.15, 1.0e-9);
        $this->convert($money, 'USD')->getCurrency()->shouldBe('USD');
    }

    function it_can_compare_one_currency_to_another_case_less()
    {
        $money1 = new Money(10.10, 'EUR');
        $money2 = new Money(25.55, 'USD');

        $this->compare($money1, $money2)->shouldBe(-1);
    }

    function it_can_compare_one_currency_to_another_case_equal()
    {
        $money1 = new Money(10.10, 'EUR');
        $money2 = new Money(15.15, 'USD');

        $this->compare($money1, $money2)->shouldBe(0);
    }
    function it_can_compare_one_currency_to_another_case_more()
    {
        $money1 = new Money(10.15, 'EUR');
        $money2 = new Money(15.15, 'USD');

        $this->compare($money1, $money2)->shouldBe(1);
    }

    function it_can_subtract_one_currency_from_another()
    {
        $money1 = new Money(110.10, 'EUR');
        $money2 = new Money(15.15, 'USD');
        $expected = new Money(100, 'EUR');

        $this->subtract($money1, $money2)->shouldBeLike($expected);
    }
}

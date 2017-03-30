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
}

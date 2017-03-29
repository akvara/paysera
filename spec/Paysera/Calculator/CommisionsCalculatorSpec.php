<?php

namespace spec\Paysera\Calculator;

use Paysera\Calculator\CommisionsCalculator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CommisionsCalculatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CommisionsCalculator::class);
    }
}

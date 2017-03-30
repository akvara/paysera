<?php

namespace spec\Paysera\Command;

use Paysera\Command\CalcCommand;
use PhpSpec\ObjectBehavior;

class CalcCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CalcCommand::class);
    }
}

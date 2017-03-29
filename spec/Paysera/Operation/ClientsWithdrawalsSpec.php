<?php

namespace spec\Paysera\Operation;

use Paysera\Operation\ClientsWithdrawals;
use PhpSpec\ObjectBehavior;

/**
 * Class ClientsWithdrawalsSpec
 * @package spec\Paysera\Operation
 */
class ClientsWithdrawalsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ClientsWithdrawals::class);
    }
}

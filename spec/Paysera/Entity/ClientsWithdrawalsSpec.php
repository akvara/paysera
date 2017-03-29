<?php

namespace spec\Paysera\Entity;

use Paysera\Entity\ClientsWithdrawals;
use PhpSpec\ObjectBehavior;

/**
 * Class ClientsWithdrawalsSpec
 * @package spec\Paysera\Entity
 */
class ClientsWithdrawalsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ClientsWithdrawals::class);
    }
}

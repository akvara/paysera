<?php

namespace spec\Paysera\Entity;

use Paysera\Entity\UsersWithdrawals;
use PhpSpec\ObjectBehavior;

/**
 * Class ClientsWithdrawalsSpec
 * @package spec\Paysera\Entity
 */
class ClientsWithdrawalsSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(UsersWithdrawals::class);
    }
}

<?php

namespace spec\Paysera\Operation;

use Paysera\Entity\Money;
use Paysera\Operation\ClientsWithdrawals;
use PhpSpec\ObjectBehavior;

/**
 * Class ClientsWithdrawalsSpec
 * @package spec\Paysera\Operation
 */
class ClientsWithdrawalsSpec extends ObjectBehavior
{
    const TEST_RATES = [
        'EUR' => 1,
        'FOR' => 1.5
    ];

    function it_is_initializable()
    {
        $this->shouldHaveType(ClientsWithdrawals::class);
    }

    function it_should_return_0_for_unknown_client()
    {
        $clientId = 83;

        $this->getClientWithdrawalCountPerWeek($clientId, new \DateTime())->shouldEqual(0);
        $this->getClientWithdrawnSumPerWeek($clientId, new \DateTime())->shouldEqual(0.00);
    }

    function it_should_add_client_withdrawal()
    {
        $clientId = 17;

        $this->addClientWithdrawal(new \DateTime(), $clientId, new Money(15, "FOR"), self::TEST_RATES);

        $this->getClientWithdrawalCountPerWeek($clientId, new \DateTime())->shouldEqual(1);
        $this->getClientWithdrawnSumPerWeek($clientId, new \DateTime())->shouldEqual(10.00); // In Base currency
    }

    function it_should_keep_clients_separated()
    {
        $client1Id = 17;
        $client2Id = 42;

        $this->addClientWithdrawal(new \DateTime(), $client1Id, new Money(30, "FOR"), self::TEST_RATES);
        $this->addClientWithdrawal(new \DateTime(), $client1Id, new Money(60, "FOR"), self::TEST_RATES);
        $this->addClientWithdrawal(new \DateTime(), $client2Id, new Money(45, "FOR"), self::TEST_RATES);

        $this->getClientWithdrawalCountPerWeek($client1Id, new \DateTime())->shouldEqual(2);
        $this->getClientWithdrawnSumPerWeek($client1Id, new \DateTime())->shouldEqual(60.00); // In Base currency

        $this->getClientWithdrawalCountPerWeek($client2Id, new \DateTime())->shouldEqual(1);
        $this->getClientWithdrawnSumPerWeek($client2Id, new \DateTime())->shouldEqual(30.00); // In Base currency
    }
}

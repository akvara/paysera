<?php

namespace Paysera\Operation;

use Paysera\Entity\Money;
use Paysera\Entity\PrivateWithdrawal;

/**
 * Class ClientsWithdrawals
 * @package Paysera\Operation
 */
class ClientsWithdrawals
{
	/** @var array */
	private $clientsWithdrawals;

    /**
     * ClientsWithdrawals constructor.
     */
    public function __construct()
    {
        $this->clientsWithdrawals = [];
    }

    /**
     * Adds info about user withdraw operation
     *
     * @param \DateTime $date
     * @param int $clientId
     * @param Money $money
     * @param array $rates
     * @return ClientsWithdrawals
     */
    public function addClientWithdrawal(\DateTime $date, $clientId, $money, $rates)
    {
        if (!isset($this->clientsWithdrawals[$clientId])) {
            $this->clientsWithdrawals[$clientId] = new PrivateWithdrawal();
        }

        $this->clientsWithdrawals[$clientId]->addWithdrawal($date, $money, $rates);

        return $this;
    }

    /**
     * Returns count of withdraw operations user did given week
     *
     * @param $clientId
     * @param \DateTime $date
     * @return int
     */
    public function getClientWithdrawalCountPerWeek($clientId, \DateTime $date)
    {
        if (!isset($this->clientsWithdrawals[$clientId])) return 0;

        return $this->clientsWithdrawals[$clientId]->getWithdrawalCountThisWeek($date);
    }

    /**
     * Returns sum in base currency the user has withdrawn this week
     *
     * @param $clientId
     * @param \DateTime $date
     * @return float
     */
    public function getClientWithdrawnSumPerWeek($clientId, \DateTime $date)
    {
        if (!isset($this->clientsWithdrawals[$clientId])) return 0.00;

        return $this->clientsWithdrawals[$clientId]->getSumTakenThisWeek($date);
    }
}

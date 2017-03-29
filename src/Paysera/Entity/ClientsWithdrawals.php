<?php

namespace Paysera\Entity;

/**
 * Class ClientsWithdrawals
 * @package Paysera\Entity
 */
class ClientsWithdrawals
{
	/** @var array */
	private $usersWithdrawals;

    /**
     * ClientsWithdrawals constructor.
     */
    public function __construct()
    {
        $this->usersWithdrawals = [];
    }

    /**
     * Adds info about user withdraw operation
     *
     * @param $user
     * @param \DateTime $date
     * @param $money
     */
    public function addUserWithdrawal($user, \DateTime $date, $money)
    {
        if (!isset($this->usersWithdrawals[$user])) {
            $this->usersWithdrawals[$user] = new PrivateWithdrawal();
        }

        $this->usersWithdrawals[$user]->addWithdrawal($date, $money);
    }

    /**
     * Returns count of withdraw operations user did this week
     *
     * @param $user
     * @return int
     */
    public function getUserWithdrawalCountPerWeek($user)
    {
        if (!isset($this->usersWithdrawals[$user])) return 0;

        return $this->usersWithdrawals[$user]->getWithdrawalCount();
    }

    /**
     * Returns sum in base currency the user has withdrawn this week
     *
     * @param $user
     * @return int
     */
    public function getUserWithdrawnSumPerWeek($user)
    {
        if (!isset($this->usersWithdrawals[$user])) return 0;

        return $this->usersWithdrawals[$user]->getSumTaken();
    }
}

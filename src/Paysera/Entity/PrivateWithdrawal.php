<?php

namespace Paysera\Entity;

use Paysera\Config;

/**
 * Class PrivateWithdrawal
 * @package Paysera\Entity
 */
class PrivateWithdrawal
{

    /** @var \DateTime */
    private $lastWithdrawalDate;

    /** @var int */
    private $withdrawalCount;

    /** @var double */
    private $sumTaken;

    /**
     * PrivateWithdrawal constructor.
     */
    public function __construct()
    {
        $this->lastWithdrawalDate = null;
        $this->withdrawalCount = 0;
        $this->sumTaken = 0;
    }

    /**
     * Getter for withdraw count
     *
     * @return int
     */
    public function getWithdrawalCount()
    {
        return $this->withdrawalCount;
    }

    /**
     * Getter for sumTaken
     *
     * @return double
     */
    public function getSumTaken()
    {
        return $this->sumTaken;
    }

    /**
     * Register user withdrawal
     *
     * @param \DateTime $date
     * @param Money $money
     * @param array $rates
     * @return $this
     */
    public function addWithdrawal(\DateTime $date, Money $money, array $rates)
    {

        if (
            !$this->lastWithdrawalDate ||
            $this->weekStartsOn($this->lastWithdrawalDate) !== $this->weekStartsOn($date)
        ) {
            $this->lastWithdrawalDate = null;
            $this->sumTaken = 0;
            $this->withdrawalCount = 0;
        }
        $this->lastWithdrawalDate = $date;
        $this->sumTaken += $money->amountIn(Config::BASE_CURRENCY, $rates);
        $this->withdrawalCount += 1;

        return $this;
    }

    /**
     * Calculates week start date
     *
     * @param $date
     * @return false|string
     */
    private function weekStartsOn($date)
    {
        if (!$date) return false;
        return date(Config::DATE_FORMAT, strtotime('Last Sunday + 1 day', $date->getTimestamp()));
    }
}

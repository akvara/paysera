<?php

namespace Paysera\Entity;

use Paysera\Config;
use Paysera\Operation\Converter;

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
    private $sumTaken; // In Base currency

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
     * @param \DateTime $date
     * @return int
     */
    public function getWithdrawalCountThisWeek(\DateTime $date)
    {
        if ($this->isNewWeek($date)) return 0;

        return $this->withdrawalCount;
    }

    /**
     * Getter for sumTaken
     *
     * @param \DateTime $date
     * @return float
     */
    public function getSumTakenThisWeek(\DateTime $date)
    {
        if ($this->isNewWeek($date)) return 0.00;

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
        $converter = new Converter($rates);
        if ($this->isNewWeek($date)) {
            $this->lastWithdrawalDate = null;
            $this->sumTaken = 0.00;
            $this->withdrawalCount = 0;
        }
        $this->lastWithdrawalDate = $date;

        $this->sumTaken += $converter->convert($money, Config::BASE_CURRENCY)->getAmount();

        $this->withdrawalCount += 1;

        return $this;
    }

    /**
     * Calculates week start date
     *
     * @param \DateTime $date
     * @return false|string
     */
    private function weekStartsOn(\DateTime $date)
    {
        if (!$date) return false;
        return date(Config::DATE_FORMAT, strtotime('Last Sunday + 1 day', $date->getTimestamp()));
    }

    /**
     * Checks if last operation was not on the same week
     * 
     * @param \DateTime $date
     * @return bool
     */
    private function isNewWeek(\DateTime $date)
    {
        return 
            !$this->lastWithdrawalDate || 
            $this->weekStartsOn($this->lastWithdrawalDate) !== $this->weekStartsOn($date);
    }
}

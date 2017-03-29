<?php

namespace Paysera\Operation;
use Paysera\Config;
use Paysera\Entity\Money;

/**
 * Class Transactor
 * @package Paysera\Operation
 */
class Transactor
{
    /** @var  array */
    private $currencies;

    /** @var array */
    private $rates;

    /** @var array */
    private $tariffs;

    /** @var ClientsWithdrawals */
    private $clientsWithdrawals;

    /**
     * Transactor constructor.
     *
     * @param array $currencies
     * @param array $rates
     * @param array $tariffs
     */
    public function __construct(array $currencies, array $rates, array $tariffs)
    {
        $this->currencies = $currencies;
        $this->rates = $rates;
        $this->tariffs = $tariffs;
        $this->clientsWithdrawals = new ClientsWithdrawals();
    }

    public function process(\DateTime $opDate, $clientId, $clientType, $opType, Money $money)
    {
        if ($opType === Config::ENUMS['Direction']['out']) {
            return $this->calculateDirectionOut($opDate, $clientId, $clientType, $money);
        }

        return $this->calculateDirectionIn($clientType, $money);
    }

    private function calculateDirectionOut(\DateTime $opDate, $clientId, $clientType, Money $money)
    {
        if ($clientType === Config::ENUMS['ClientType']['company']) {
            return CommissionsCalculator::commissionsCashOutCompany($money, $this->tariffs, $this->rates);
        }

        $countOfWithdrThisWeek = $this->clientsWithdrawals->getClientWithdrawalCountPerWeek($clientId);
        $sumOfWithdrThisWeek = $this->clientsWithdrawals->getClientWithdrawnSumPerWeek($clientId);

        $this
            ->clientsWithdrawals
            ->addClientWithdrawal(
                $opDate,
                $clientId,
                $money,
                $this->rates
            );

        return CommissionsCalculator::commissionsCashOutPrivate(
            $money,
            $countOfWithdrThisWeek,
            $sumOfWithdrThisWeek,
            $this->tariffs,
            $this->rates
        );
    }

    private function calculateDirectionIn($clientType, Money $money)
    {
        if ($clientType === Config::ENUMS['ClientType']['company']) {
            return CommissionsCalculator::commissionsCashInCompany($money, $this->tariffs, $this->rates);
        }

        return CommissionsCalculator::commissionsCashInPrivate($money, $this->tariffs, $this->rates);
    }
}

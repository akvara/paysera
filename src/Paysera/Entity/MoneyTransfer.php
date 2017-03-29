<?php

namespace Paysera\Entity;


use Paysera\Config;

/**
 * Class MoneyTransfer
 * @package Paysera\Entity
 */
class MoneyTransfer
{
    /** @var Money */
    private $money;

    /** @var string */
    private $direction;

    /** @var string */
    private $clientType;

    /** @var integer */
    private $clientId;

    /** @var \DateTime */
    private $date;

    /**
     * MoneyTransfer constructor.
     *
     * @param Money $money
     * @param string $direction
     * @param string $clientType
     * @throws \Exception
     */
    public function __construct(Money $money, $direction, $clientType, $clientId = null, $date = null)
    {
        if (!in_array($direction, array_values(Config::ENUMS['Direction']))) {
            throw new \Exception('Illegal direction.');
        }

        if (!in_array($clientType, array_values(Config::ENUMS['ClientType']))) {
            throw new \Exception('Illegal client type.');
        }

        $this->money = $money;
        $this->direction = $direction;
        $this->clientType = $clientType;
        $this->clientId = $clientId;
        $this->date = $date;
    }

    /**
     * Getter for Money's currency
     *
     * @return string
     */
    public function currency()
    {
        return $this->money->getCurrency();
    }

    /**
     * Calculates commissions
     *
     * @param array $tariffs
     * @param array $rates
     * @return int|Money
     */
    public function commission(array $tariffs, array $rates)
    {
        if ($this->direction === Config::ENUMS['Direction']['out']) {
            return $this->calculateDirectionOut($tariffs, $rates);
        }
        return $this->calculateDirectionIn($tariffs, $rates);
    }

    /**
     * Calculates commissions for inbound money
     *
     * @param array $tariffs
     * @param array $rates
     * @return Money
     */
    private function calculateDirectionIn(array $tariffs, array $rates)
    {
    }

    /**
     * Calculates commissions for outbound money
     *
     * @param array $tariffs
     * @param array $rates
     * @return int|Money
     */
    private function calculateDirectionOut(array $tariffs, array $rates)
    {
        if ($this->clientType === Config::ENUMS['ClientType']['private']) {
            return $this->calculateDirectionOutForPrivate();
        }

    }

    /**
     * @return int
     */
    private function calculateDirectionOutForPrivate()
    {
        return 0;
    }
}

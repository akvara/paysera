<?php

namespace Paysera\Entity;


use Paysera\Config;

/**
 * Class Payment
 * @package Paysera\Entity
 */
class Payment
{
    /** @var Money */
    private $money;

    /** @var string */
    private $direction;

    /** @var string */
    private $clientType;

    /**
     * Payment constructor.
     *
     * @param Money $money
     * @param string $direction
     * @param string $clientType
     * @throws \Exception
     */
    public function __construct(Money $money, $direction, $clientType)
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
     * Calculates commisions
     *
     * @param array $tariffs
     * @param array $rates
     * @return int|Money
     */
    public function commision(array $tariffs, array $rates)
    {
        if ($this->direction === Config::ENUMS['Direction']['out']) {
            return $this->calculateDirectionOut($tariffs, $rates);
        }
        return $this->calculateDirectionIn($tariffs, $rates);
    }

    /**
     * Calculates commisions for inbound money
     *
     * @param array $tariffs
     * @param array $rates
     * @return Money
     */
    private function calculateDirectionIn(array $tariffs, array $rates)
    {
        $upperLimit = new Money($tariffs['IN_MAX'], Config::BASE_CURRENCY);

        $comm = $this->money->multipliedBy($tariffs['IN_RATE'] / 100);

        if ($comm->isMore($upperLimit, $rates)) {
            return new Money(
                $upperLimit->amountIn($comm->getCurrency(), $rates),
                $this->money->getCurrency()
            );
        }

        return $comm;
    }

    /**
     * Calculates commisions for outbound money
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

        $lowerLimit = new Money($tariffs['OUT_MIN_LEG'], Config::BASE_CURRENCY);
        $comm = $this->money->multipliedBy($tariffs['OUT_RATE_LEG'] / 100);

        if ($lowerLimit->isMore($comm, $rates)) {
            return new Money(
                $lowerLimit->amountIn($comm->getCurrency(), $rates),
                $this->money->getCurrency()
            );
        }

        return $comm;
    }

    /**
     * @return int
     */
    private function calculateDirectionOutForPrivate()
    {
        return 0;
    }
}

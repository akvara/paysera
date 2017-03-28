<?php

namespace Paysera;


class Payment
{
    /** @var Money */
    private $money;

    /** @var string */
    private $direction;

    /** @var string */
    private $payee;

    /**
     * Payment constructor.
     * @param Money $money
     * @param string $direction
     * @param string $payee
     * @throws \Exception
     */
    public function __construct(Money $money, $direction, $payee)
    {
        if (!in_array($direction, array_values(Config::ENUMS['Direction']))) {
            throw new \Exception('Illegal direction.');
        }

        if (!in_array($payee, array_values(Config::ENUMS['ClientType']))) {
            throw new \Exception('Illegal client type.');
        }

        $this->money = $money;
        $this->direction = $direction;
        $this->payee = $payee;
    }

    public function commision(array $tariffs, array $rates)
    {
        if ($this->direction === Config::ENUMS['Direction']['out']) {
            return $this->calculateDirectionOut($tariffs, $rates);
        }
        return $this->calculateDirectionIn($tariffs, $rates);
    }

    private function calculateDirectionIn(array $tariffs, array $rates)
    {
        $upperLimit = new Money($tariffs['IN_MAX'], Config::BASE_CURRENCY);

        $comm = $this->money->multiply($tariffs['IN_RATE']);

        var_dump($upperLimit->amountIn($comm->getCurrency(), $rates));
        if ($comm->isMore($upperLimit, $rates)) {
            return new Money(
                $upperLimit->amountIn($comm->getCurrency(), $rates),
                $this->money->getCurrency()
            );
        }


        return $comm;
    }

    private function calculateDirectionOut(array $tariffs, array $rates)
    {
        $comm = $this->money;

        return $comm;

    }
    /**
     * @return string
     */
    public function currency()
    {
//        var_dump( $this->money->currency() );
        return $this->money->getCurrency();
    }
}

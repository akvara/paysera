<?php

namespace Paysera\Calculator;

/**
 * Class CommisionsCalculator
 * @package Paysera\Calculator
 */
class CommisionsCalculator
{
    /**
     * Returns commisions for cashing in for private client
     *
     * @param double $sum
     * @return float
     */
    static public function commisionsCashInPrivate($sum)
    {
        return 0;
    }

    /**
     * Returns commisions for cashing out for private client
     *
     * @param double $sum
     * @return float
     */
    static public function commisionsCashOutPrivate($sum)
    {
        return 0;
    }

    /**
     * Returns commisions for cashing in for company/legal
     *
     * @param double $sum
     * @return float
     */
    static public function commisionsCashInCompany($sum)
    {
        return 0;
    }

    /**
     * Returns commisions for cashing out for company/legal
     *
     * @param double $sum
     * @return float
     */
    static public function commisionsCashOutCompany($sum)
    {
        return 0;
    }
}

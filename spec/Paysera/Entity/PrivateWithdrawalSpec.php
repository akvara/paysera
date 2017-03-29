<?php

namespace spec\Paysera\Entity;

use Paysera\Entity\Money;
use Paysera\Entity\PrivateWithdrawal;
use PhpSpec\ObjectBehavior;

/**
 * Class PrivateWithdrawalSpec
 * @package spec\Paysera\Entity
 */
class PrivateWithdrawalSpec extends ObjectBehavior
{
    const TEST_RATES = [
        'EUR' => 1,
        'FOR' => 1.5
    ];

    function it_is_initializable()
    {
        $this->shouldHaveType(PrivateWithdrawal::class);
    }

    function it_should_add_first_withdrawal_as_first()
    {
        $this
            ->addWithdrawal(new \DateTime('2017-03-30'), new Money(20, "FOR"), self::TEST_RATES)
            ->getWithdrawalCountThisWeek(new \DateTime('2017-03-30'))
            ->shouldEqual(1);
    }

    function it_should_accumulate_weeks_withdrawals()
    {
        $this->addWithdrawal(new \DateTime('2017-03-27'), new Money(15, "FOR"), self::TEST_RATES);
        $this->addWithdrawal(new \DateTime('2017-03-28'), new Money(30, "FOR"), self::TEST_RATES);
        $this->addWithdrawal(new \DateTime('2017-03-29'), new Money(45, "FOR"), self::TEST_RATES);
        $this->addWithdrawal(new \DateTime('2017-03-30'), new Money(60, "FOR"), self::TEST_RATES);

        $this->getWithdrawalCountThisWeek(new \DateTime('2017-03-30'))->shouldEqual(4);
        $this->getSumTakenThisWeek(new \DateTime('2017-03-30'))->shouldEqual(100.00);
    }

    function it_should_start_new_week_withdrawals_from_zero()
    {
        $this->addWithdrawal(new \DateTime('2017-03-25'), new Money(15, "FOR"), self::TEST_RATES);
        $this->addWithdrawal(new \DateTime('2017-03-26'), new Money(30, "FOR"), self::TEST_RATES);
        $this->addWithdrawal(new \DateTime('2017-03-27'), new Money(60, "FOR"), self::TEST_RATES);

        $this->getWithdrawalCountThisWeek(new \DateTime('2017-03-30'))->shouldEqual(1);
        $this->getSumTakenThisWeek(new \DateTime('2017-03-30'))->shouldEqual(40.00);
    }

    function it_should_not_count_withdrawals_older_than_one_week()
    {
        $this->addWithdrawal(new \DateTime('2017-03-01'), new Money(15, "FOR"), self::TEST_RATES);
        $this->addWithdrawal(new \DateTime('2017-03-10'), new Money(30, "FOR"), self::TEST_RATES);
        $this->addWithdrawal(new \DateTime('2017-03-20'), new Money(60, "FOR"), self::TEST_RATES);

        $this->getWithdrawalCountThisWeek(new \DateTime('2017-03-30'))->shouldEqual(0);
        $this->getSumTakenThisWeek(new \DateTime('2017-03-30'))->shouldEqual(0.00);
    }
}

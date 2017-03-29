<?php

namespace spec\Paysera\Operation;

use Paysera\Entity\Money;
use Paysera\Operation\Transactor;
use PhpSpec\ObjectBehavior;

/**
 * Class TransactorSpec
 * @package spec\Paysera\Operation
 */
class TransactorSpec extends ObjectBehavior
{
    const TEST_CURRENCIES = [
        'EUR' => 0.01,
        'USD' => 0.01,
        'JPY' => 1
    ];

    const TEST_RATES = [
        'EUR' => 1,
        'USD' => 1.1497,
        'JPY' => 129.53
    ];

    const TEST_TARIFFS = [
        'IN_RATE'           => 0.03,
        'IN_MAX'            => 5,
        'OUT_RATE_NAT'      => 0.3,
        'OUT_LIMIT_SUM_NAT' => 1000,
        'OUT_LIMIT_OP_NAT'  => 3,
        'OUT_RATE_LEG'      => 0.3,
        'OUT_MIN_LEG'       => 0.5
    ];

    const TEST_DATA = [
        ['2016-01-05',1,'natural','cash_in',200.00,'EUR'],
        ['2016-01-06',2,'legal','cash_out',300.00,'EUR'],
        ['2016-01-06',1,'natural','cash_out',30000,'JPY'],
        ['2016-01-07',1,'natural','cash_out',1000.00,'EUR'],
        ['2016-01-07',1,'natural','cash_out',100.00,'USD'],
        ['2016-01-10',1,'natural','cash_out',100.00,'EUR'],
        ['2016-01-10',2,'legal','cash_in',1000000.00,'EUR'],
        ['2016-01-10',3,'natural','cash_out',1000.00,'EUR'],
        ['2016-02-15',1,'natural','cash_out',300.00,'EUR']
    ];

    const EXPEXTED_RESULTS = [
        "0.06",
        "0.90",
        "0",
        "0.70",
        "0.30",
        "0.30",
        "5.00",
        "0.00",
        "0.00"
    ];

    function let()
    {
        $this->beConstructedWith(self::TEST_CURRENCIES, self::TEST_RATES, self::TEST_TARIFFS);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Transactor::class);
    }

    function it_should_return_0_on_0_sum_private_cash_in()
    {
        $this
            ->process(new \DateTime(), 1, 'natural', 'cash_in', new Money(0, 'EUR'))
            ->getAmount()
            ->shouldEqual(0.00);
    }

    function it_should_return_0_on_0_sum_private_cash_out()
    {
        $this
            ->process(new \DateTime(), 1, 'natural', 'cash_out', new Money(0, 'EUR'))
            ->getAmount()
            ->shouldEqual(0.00);
    }

    function it_should_return_0_on_0_sum_company_cash_in()
    {
        $this
            ->process(new \DateTime(), 1, 'legal', 'cash_in', new Money(0, 'EUR'))
            ->getAmount()
            ->shouldEqual(0.00);
    }

    function it_should_return_MIN_on_0_sum_company_cash_out()
    {
        $this
            ->process(new \DateTime(), 1, 'legal', 'cash_out', new Money(0, 'EUR'))
            ->getAmount()
            ->shouldEqual(self::TEST_TARIFFS['OUT_MIN_LEG']);
    }

    function it_should_pass_example_data()
    {
        foreach(self::TEST_DATA as $key=>$value) {
        $this
            ->process(new \DateTime($value[0]), $value[1], $value[2], $value[3], new Money($value[4], $value[5]))
            ->roundedPrint(self::TEST_CURRENCIES)
            ->shouldBe(self::EXPEXTED_RESULTS[$key]);
        }
    }
}

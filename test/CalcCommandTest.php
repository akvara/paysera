<?php
/**
 * User: andrius
 * Date: 17.3.27
 * Time: 10.55
 */

namespace Tests;

use Paysera\Command\CalcCommand;
use PHPUnit\Framework\TestCase as TestCase;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Tester\CommandTester;

class CalcCommandTest extends TestCase
{
    const EXPEXTED_RESULTS = <<<OUT
0.06
0.90
0
0.70
0.30
0.30
5.00
0.00
0.00

OUT;

    /** @test
    *   @expectedException RuntimeException
    */
    public function it_throws_exception_if_argument_is_not_supplied()
    {
        $tester = new CommandTester(new CalcCommand());
        $tester->execute([]);
    }

    /** @test */
    public function it_displays_a_success_message_if_argument_is_supplied()
    {
        $tester = new CommandTester(new CalcCommand());
        $tester->execute([
            'file' => './input.csv'
        ]);

        $this->assertEquals(self::EXPEXTED_RESULTS, $tester->getDisplay());
    }
}

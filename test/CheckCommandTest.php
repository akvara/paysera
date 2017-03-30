<?php
/**
 * User: andrius
 * Date: 17.3.27
 * Time: 10.55
 */

namespace Tests;

use Paysera\Command\CheckCommand;
use PHPUnit\Framework\TestCase as TestCase;
use Symfony\Component\Console\Tester\CommandTester;

class CheckCommandTest extends TestCase
{
    const EXPEXTED_RESULTS_SELF_TEST_ = <<<OUT
Checking system integrity
Config files are correct.

OUT;

    const EXPEXTED_RESULTS_FULL_TEST_ = <<<OUT
Checking system integrity
Config files are correct.
User supplied file ./input.csv is correct.

OUT;

    /** @test
    */
    public function it_checks_only_itself_if_argument_is_not_supplied()
    {
        $tester = new CommandTester(new CheckCommand());
        $tester->execute([]);

        $this->assertEquals(self::EXPEXTED_RESULTS_SELF_TEST_, $tester->getDisplay());
    }

    /** @test */
    public function it_displays_a_success_message_if_argument_is_supplied()
    {
        $tester = new CommandTester(new CheckCommand());
        $tester->execute([
            'file' => './input.csv'
        ]);

        $this->assertEquals(self::EXPEXTED_RESULTS_FULL_TEST_, $tester->getDisplay());
    }
}

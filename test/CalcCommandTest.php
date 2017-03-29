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
    /** @test
    *   @expectedException RuntimeException
    */
    public function it_throws_exception_if_argument_is_not_supplied()
    {
        $tester = new CommandTester(new CalcCommand());
        $tester->execute([]);
    }

    /** @test */
    /** @test */
    public function it_displays_a_success_message_if_argument_is_supplied()
    {
        // Stop here and mark this test as incomplete.
        $this->markTestIncomplete(
            'This test has not been implemented yet.'
        );


        $tester = new CommandTester(new CalcCommand());
        $tester->execute([
            'file' => 'file'
        ]);

        var_dump($tester->getDisplay());
        $this->assertContains('Getting data from file file', $tester->getDisplay());
    }
}

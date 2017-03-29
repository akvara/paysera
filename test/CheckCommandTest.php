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
    /** @test */
    public function it_displays_a_success_message_with_no_arguments()
    {
        $tester = new CommandTester(new CheckCommand());
        $tester->execute([]);
        $this->assertContains('Config files are correct', $tester->getDisplay());
    }
}

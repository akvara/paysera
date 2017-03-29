<?php

namespace spec\Paysera\Command;

use Paysera\Command\CheckCommand;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class CheckCommandSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(CheckCommand::class);
    }

    function it_passes_tests_if_all_config_files_are_present(
        InputInterface $input,
        OutputInterface $output
    ) {

        $this->execute($input, $output)->shouldReturn(0);
    }
}

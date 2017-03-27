<?php
/**
 * User: akvara
 * Date: 17.3.27
 * Time: 10.00
 */

namespace Paysera;


use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ImportCommand extends Command
{
    public function configure()
    {
        $this
            ->setName('import')
            ->setDescription('Paysera')
            ->addArgument('file', InputArgument::REQUIRED, "File to import data from");

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getArgument('file');
        $info = 'Getting data from file ' . $fileName;
        $output->writeln("<info>{$info}</info>");
    }
}
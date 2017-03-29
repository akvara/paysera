<?php
/**
 * User: akvara
 * Date: 17.3.27
 * Time: 10.00
 */

namespace Paysera\Command;

use Paysera\Config;
use Paysera\IO\ConfigLoader;
use Paysera\Validator\SystemIntegrityValidator;
use Paysera\Validator\UserDataValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CheckCommand
 * @package Paysera\Command
 */
class CheckCommand extends Command
{
    /**
     * Configure Check command
     */
    public function configure()
    {
        $this
            ->setName('check')
            ->addArgument('file', InputArgument::OPTIONAL)
            ->setDescription('Check App integrity');
    }

    /**
     * Execute check command
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $currencies = ConfigLoader::loadConfig(Config::CURRENCIES);
        $rates = ConfigLoader::loadConfig(Config::RATES);

        $systemIntergityCheck = new SystemIntegrityValidator($currencies, $rates);
        $systemIntergityCheck->validate();

        $output->writeln("<info>Config files are correct</info>");

        if ($userFile = $input->getArgument('file')) {
            $userDataCheck = new UserDataValidator($currencies, $userFile);
            $userDataCheck->validate();

            $output->writeln("<info>User supplied file " . $userFile. " is correct</info>");
        }

        return 0;
    }
}

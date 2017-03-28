<?php
/**
 * User: akvara
 * Date: 17.3.27
 * Time: 10.00
 */

namespace Paysera\Command;

use Paysera\Config;
use Paysera\IO\Loader;
use Paysera\Validator\CsvFileValidator;
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
        $validator = new CsvFileValidator();

        foreach (Config::CONFIG_FILES as $fileName => $fileSpec) {
            $validator->validateFile($fileName, $fileSpec);
        }

        $currencies = Loader::loadConfig(Config::CURRENCIES);
        $rates = Loader::loadConfig(Config::RATES);

        $validator->checkCurrencyRates($currencies, $rates);

        $output->writeln("<info>Config files are correct</info>");

        if ($userFile = $input->getArgument('file')) {
            $validator->setCurrencies(array_keys($currencies));
            $validator->validateFile($userFile, ['format' => Config::USER_DATA_FORMAT]);
            $output->writeln("<info>User supplied file " . $userFile. " is correct</info>");
        }
        return 0;
    }
}

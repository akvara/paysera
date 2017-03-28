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

class CheckCommand extends Command
{
    const CURRENCIES = 'curr_rates.csv',
          PRICELIST = 'prices.csv';

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
     * @return int|null
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $validator = new CsvFileValidator();

        foreach (Config::CONFIG_FILES as $fileName => $fileSpec) {
            $validator->validateFile($fileName, $fileSpec);
        }
        $output->writeln("<info>Config files are correct</info>");

        if ($userFile = $input->getArgument('file')) {
            $currencies = Loader::loadConfig(Config::CURRENCIES);
            $validator->setCurrencies(array_keys($currencies));
            $validator->validateFile($userFile, ['format' => Config::USER_DATA_FORMAT]);
            $output->writeln("<info>User supplied file " . $userFile. " is correct</info>");
        }
        return 0;
    }


}
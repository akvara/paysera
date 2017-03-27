<?php
/**
 * User: akvara
 * Date: 17.3.27
 * Time: 10.00
 */

namespace Paysera;

use Symfony\Component\Console\Command\Command;
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
            ->setDescription('Check App integrity');
    }

    /**
     * Execute check command
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        IntegrityChecker::check(Config::CONFIG_FILES);
    }
}
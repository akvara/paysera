<?php
/**
 * User: akvara
 * Date: 17.3.27
 * Time: 10.00
 */

namespace Paysera\Command;

use Paysera\Config;
use Paysera\Entity\Money;
use Paysera\IO\ConfigLoader;
use Paysera\IO\FileReader;
use Paysera\Validator\SystemIntegrityValidator;
use Paysera\Validator\UserDataValidator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CalcCommand
 * @package Paysera\Command
 */
class CalcCommand extends Command
{
    /**
     *
     */
    public function configure()
    {
        $this
            ->setName('calc')
            ->setDescription('Calculate commissions ')
            ->addArgument('file', InputArgument::REQUIRED, "File to import data from");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        // Reading config files
        $fileName = $input->getArgument('file');
        $currencies = ConfigLoader::loadConfig(Config::CURRENCIES);
        $rates = ConfigLoader::loadConfig(Config::RATES);
        $tariffs = ConfigLoader::loadConfig(Config::TARIFFS);

        // Cheking system integrity
        $systemIntergityCheck = new SystemIntegrityValidator($currencies, $rates);
        $systemIntergityCheck->validate();

        // Checking user file validity
        $userDataCheck = new UserDataValidator($currencies, $fileName);
        $userDataCheck->validate();

        // Processing file
        $reader = new FileReader($fileName);
        $handle = $reader->getHandle();
        while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
            $opDate = new \DateTime($data[0]);
            $clientId = intval($data[1]);
            $clientType = $data[2];
            $opType = $data[3];
            $money = new Money(floatval($data[4]),$data[5]);
            
        }

        $reader->close();

        return 0;
    }
}

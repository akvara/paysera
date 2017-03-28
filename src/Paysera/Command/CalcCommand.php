<?php
/**
 * User: akvara
 * Date: 17.3.27
 * Time: 10.00
 */

namespace Paysera\Command;


use Paysera\Config;
use Paysera\IO\Loader;
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
            ->setDescription('Calculate commisions ')
            ->addArgument('file', InputArgument::REQUIRED, "File to import data from");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $fileName = $input->getArgument('file');
        $info = 'Getting data from file ' . $fileName;
        $output->writeln("<info>{$info}</info>");


        $currencies = Loader::loadConfig(Config::CURRENCIES);
        $prices = Loader::loadConfig(Config::TARIFFS);
//        $row = 1;
//
//        $reader = new FileReader($fileName);
//        $handle = $reader->getHandle();
//
//
//            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
//                $num = count($data);
//                echo "<p> $num fields in line $row: <br /></p>\n";
//                $row++;
//                for ($c=0; $c < $num; $c++) {
//                    echo $data[$c] . "<br />\n";
//                }
//            }
//         $reader->close();

        return 0;
    }

}
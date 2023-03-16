<?php

declare(strict_types=1);

namespace Artisan\Database;

use Artisan\Contract\DatabaseSeedInterface;
use Contest\Contract\Config\ConfigInterface as Config;
use Psr\Container\ContainerInterface as Container;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'db:seed')]
class Seed extends Command
{

    protected static $defaultDescription = 'Füllt die Datenbank mit zufälligen Inhalten.';


    public function __construct
    (
        public readonly Container $container,
        public readonly Config $config
    ){
        parent::__construct();
    }


    protected function configure(): void
    {

        $this
            ->setHelp('Dieser Befehl befüllt die Datenbank mit einer Reihe zufälligen Inhalten.')
            ->addOption('clean', 'c', InputOption::VALUE_NONE, 'Löscht alle Inhalt der Datenbank.')
            ->addOption('multiple', 'm', InputOption::VALUE_REQUIRED, 'Legt fest, wie viel Male mehr Datensatze angelegt werden soll. Wie groß der Grundwert ist, liegt in den Klassen selbst.', 1);

    }


    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        if ( filter_var($input->getOption('multiple'), FILTER_VALIDATE_INT) === false )
        {

            $output->writeln("\n<error>                                                   </error>");
            $output->writeln('<error>  invalid option: value of multiple must be a int  </error>');
            $output->writeln("<error>                                                   </error>\n");

            return Command::INVALID;

        }

        $tables = array_map(fn($table) => $this->container->make($table), $this->config->get('artisan.database'));
        $tables = array_filter($tables, fn($table) => $table instanceof DatabaseSeedInterface);

        if ($input->getOption('clean'))
        {

            foreach($tables as $table) {
                $table->down();
            }

        }

        foreach($tables as $table) {
            $table->up( (int) $input->getOption('multiple') );
        }

        return Command::SUCCESS;

    }

}
<?php

declare(strict_types=1);

namespace Artisan\Database;

use Artisan\Contract\DatabaseMigrateInterface;
use Contest\Contract\Config\ConfigInterface as Config;
use Psr\Container\ContainerInterface as Container;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'db:migrate')]
class Migrate extends Command
{

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
            ->setHelp('Dieser Befehl erzeugt alle angegeben Tabellen, wenn sie noch nicht existieren.')
            ->addOption('drop', 'd', InputOption::VALUE_NONE, 'Löscht alle Tabellen.');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $tables = array_map(fn($table) => $this->container->make($table), $this->config->get('artisan.database'));
        $tables = array_filter($tables, fn($table) => $table instanceof DatabaseMigrateInterface);

        if ($input->getOption('drop'))
        {

            foreach($tables as $table) {
                $table->destroy();
            }

        }

        foreach($tables as $table) {
            $table->create();
        }

        return Command::SUCCESS;

    }

}
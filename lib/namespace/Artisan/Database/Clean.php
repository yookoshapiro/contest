<?php

declare(strict_types=1);

namespace Artisan\Database;

use Artisan\Contract\DatabaseSeedInterface;
use Contest\Contract\Config\ConfigInterface as Config;
use Psr\Container\ContainerInterface as Container;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'db:clean')]
class Clean extends Command
{

    protected static $defaultDescription = 'Leert alle Tabellen der Datenbank';


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
            ->setHelp('Dieser Befehl leert alle Tabellen der Datenbank vollständig.');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $tables = array_map(fn($table) => $this->container->make($table), $this->config->get('artisan.database'));
        $tables = array_filter($tables, fn($table) => $table instanceof DatabaseSeedInterface);

        foreach($tables as $table) {
            $table->down();
        }

        return Command::SUCCESS;

    }

}
<?php

declare(strict_types=1);

namespace Artisan\Database;

use Illuminate\Database\Connection;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'db:import')]
class Import extends Command
{

    public function __construct
    (
        public readonly Connection $connection
    ){
        parent::__construct();
    }

    protected static $defaultDescription = 'Importiert ein SQL-Dump';

    protected function configure(): void
    {

        $this
            ->setHelp('Diese Befehlt fügt die Inhalte einer SQL-Dump Datei in die Datenbank ein.')
            ->addOption('path', 'p', InputOption::VALUE_REQUIRED, 'Pfad zur dump-Datei');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $path = root_path('var/database/current.sql');

        if ($input->getOption('path') !== null) {
            $path = root_path( $input->getOption('path') );
        }

        $content = file_get_contents( $path );
        $this->connection->getPdo()->exec( $content );

        return Command::SUCCESS;

    }

}
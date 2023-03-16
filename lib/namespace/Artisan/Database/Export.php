<?php

declare(strict_types=1);

namespace Artisan\Database;

use Contest\Contract\Config\ConfigInterface as Config;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'db:export')]
class Export extends Command
{

    public function __construct
    (
        public readonly Config $config
    ){
        parent::__construct();
    }

    protected static $defaultDescription = 'Exportiert die Datenbank';

    protected function configure(): void
    {

        $this
            ->setHelp('Diese Befehlt exportiert alle Inhalten der Datenbank in einer Datei.')
            ->addOption('path', 'p', InputOption::VALUE_REQUIRED, 'Pfad zur dump-Datei')
            ->addOption('docker', 'd', InputOption::VALUE_NONE, 'Mithilfe von Docker aufrufen');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $path = root_path('var/database/current.sql');
        $config = $this->config->get('database.connection');

        if ($input->getOption('path') !== null) {
            $path = root_path( $input->getOption('path') );
        }

        $command = 'mysqldump --user '. $config['username'] .' --password='. $config['password'] .' contest > ' . $path;

        if ($input->getOption('docker')) {
            $command = 'docker exec mariadb ' . $command;
        }

        exec($command);

        return Command::SUCCESS;

    }

}
<?php

declare(strict_types=1);

namespace Artisan\Run;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'run:update')]
class Update extends Command
{

    protected static $defaultDescription = 'Führt ein Update aller Pakete durch';

    protected function configure(): void
    {

        $this
            ->setHelp('Führt ein Update aller Pakete im passenden Ordner aus.');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        echo shell_exec('php artisan run:npm update');
        echo shell_exec('php artisan run:composer update');

        return Command::SUCCESS;

    }

}
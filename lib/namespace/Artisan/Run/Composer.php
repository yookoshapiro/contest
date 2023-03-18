<?php

declare(strict_types=1);

namespace Artisan\Run;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'run:composer')]
class Composer extends Command
{

    protected static $defaultDescription = 'Führt ein Composer aus';

    protected function configure(): void
    {

        $this
            ->addArgument('arg', InputArgument::REQUIRED, 'Auszuführender Befehl')
            ->setHelp('Führt Composer im passenden Ordner aus.');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        echo shell_exec('cd lib && composer ' . $input->getArgument('arg'));

        return Command::SUCCESS;

    }

}
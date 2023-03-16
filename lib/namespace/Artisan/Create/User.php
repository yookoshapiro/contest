<?php

declare(strict_types=1);

namespace Artisan\Create;

use Faker\Factory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Contest\Database\User as TableUser;

#[AsCommand(name: 'create:user')]
class User extends Command
{

    protected static $defaultDescription = 'Erzeugt einen Benutzer in der Datenbank';


    protected function configure(): void
    {

        $this
            ->setHelp('Dieser Befehl leert alle Tabellen der Datenbank vollständig.')
            ->addArgument('user', InputArgument::REQUIRED, 'Name des Benutzers')
            ->addArgument('password', InputArgument::OPTIONAL, 'Password des Benutzers (optional, ohne wird ein zufälliges Passwort erzeugt)')
            ->addOption('admin', 'a', InputOption::VALUE_NONE,'Soll der Benutzer ein Admin sein')
            ->addOption('mail', 'm', InputOption::VALUE_REQUIRED,'E-Mail des Benutzers');

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        if (!$this->userExists( $input->getArgument('user'), $output )) {
            return Command::FAILURE;
        }

        $user = new TableUser;
        $faker = Factory::create('de_DE');

        $user->name = $input->getArgument('user');
        $user->password = $input->getArgument('password') ?? $faker->password;
        $user->email = $input->getOption('mail');
        $user->is_admin = $input->getOption('admin');

        $user->save();

        return Command::SUCCESS;

    }


    protected function userExists(string $user, $output): bool
    {

        $users = TableUser::query()->where('name', $user);

        if ($users->count() === 0) {
            return true;
        }

        $output->writeln("\n<error>                                    </error>");
        $output->writeln('<error>     user ' . $user . ' already exists      </error>');
        $output->writeln("<error>                                    </error>\n");

        return false;

    }

}
<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:user:create',
    description: 'Creates a new user.',
)]
class CreateUserCommand extends Command
{
    protected function configure(): void
    {
        $this->addArgument('username', InputArgument::OPTIONAL, 'The new Username of the new user');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $username = $input->getArgument('username');

        if(is_string($username) === false) {
            $output->writeln('<error>Please enter a Username</error>');
            return self::FAILURE;
        }

        // do magic

        $output->writeln(
            sprintf('<info>Successfully created user with Username [%s]</info>', $username)
        );

        return self::SUCCESS;
    }
}

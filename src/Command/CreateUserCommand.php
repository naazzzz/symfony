<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(name: 'app:user-create')]
class CreateUserCommand extends Command
{

    public function __construct(
        public UserRepository $userRepository,
    )
    {
        parent::__construct();
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {

        $args = (array)$input->getArguments();

        $this->userRepository->save(new User($args['name'], password_hash($args['password'],PASSWORD_DEFAULT), $args['email']),true);

        $output->writeln('Success!');

        return Command::SUCCESS;
    }

    protected function configure()
    {
        $this->addArgument(name: 'name');
        $this->addArgument(name: "password");
        $this->addArgument(name: "email");
    }
}
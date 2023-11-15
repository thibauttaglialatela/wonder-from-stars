<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Create the admin user',
)]
class CreateAdminCommand extends Command
{
    public function __construct(private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the user')
            ->addArgument('password', InputArgument::REQUIRED, 'The password of the user')
            ->addArgument('pseudo', InputArgument::OPTIONAL, 'The pseudo of the user. Not mandatory')
            ->setHelp('This command allows you to create an admin user');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln([
            'Admin User creator',
            '=========',
            '',
        ]);
        $io = new SymfonyStyle($input, $output);

        $email = $input->getArgument('email');

        $plainPassword = $input->getArgument('password');

        $pseudo = $input->getArgument('pseudo');

        // tester si le user existe déjà
        $user = $this->userRepository->findOneBy(['email' => $email]);
        if ($user) {
            throw new \InvalidArgumentException('User already exists');
        }
        // code to create the admin user
        $user = new User();
        $user->setEmail($email);
        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);
        $user->setPseudo($pseudo);
        $user->setRoles(['ROLE_ADMIN']);
        $this->userRepository->save($user, true);

        $io->success('A new admin User has been created.');

        return Command::SUCCESS;
    }
}

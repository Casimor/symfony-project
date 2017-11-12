<?php
// src/BenProjectBundle/Command/CreateUserCommand.php

namespace BenProjectBundle\Command;

use BenProjectBundle\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class CreateUserCommand extends ContainerAwareCommand
{
	protected function configure()
	{
		$this
			->setName('app:create-user')
			->setDescription('Créer un nouvel utilisateur.')
			->setHelp('app:create-user [username] [email] [password] [role] (user or admin)')
			->addArgument('username', InputArgument::REQUIRED, 'the username')
			->addArgument('email', InputArgument::REQUIRED, 'email of the user')
			->addArgument('password', InputArgument::REQUIRED, 'password of the user')
			->addArgument('role', InputArgument::REQUIRED, 'role of the user')
		;
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$username = $input->getArgument('username');
		$email = $input->getArgument('email');
		$passwordPlainText = $input->getArgument('password');
		$role = $input->getArgument('role');

		$userManager = $this->getContainer()->get('app.user');
        $userManager->create($input->getArgument('username'));

        $output->writeln('User successfully generated!');
	}
}
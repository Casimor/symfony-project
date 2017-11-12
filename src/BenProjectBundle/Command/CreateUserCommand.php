<?php
// src/BenProjectBundle/Command/CreateUserCommand.php

namespace BenProjectBundle\Command;

use BenProjectBundle\Entity\User;
use Symfony\Component\Console\Command\Command;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\HttpFoundation\Request;
use BenProjectBundle\Service\CreateUser;

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
        $output->writeln('User successfully generated!');

        $user = new User();
        $user->setUsername($username); 
        $user->setEmail($email);
        $user->setPassword(password_hash($passwordPlainText, PASSWORD_BCRYPT));
        if ($role == "admin")
        	$user->setRoles(array('ROLE_ADMIN'));
        else
        	$user->setRoles(array('ROLE_USER')); 
        $em = $this->getContainer()->get('doctrine')->getManager();
        $em->persist($user);
        $em->flush();
	}
}
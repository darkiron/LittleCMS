<?php
namespace CMS\BlogBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use CMS\BlogBundle\Entity\User;

class CreateUserCommand extends ContainerAwareCommand
{

  protected function configure(){
    $this
      ->setName('user:create')
      ->setDescription('Create new user')
      ->setHelp('Allows to create user')
      ->addArgument('username', InputArgument::REQUIRED, 'The username of the user.')
      ->addArgument('email', InputArgument::REQUIRED, 'The email of the user.')
    ;
  }

  protected function execute(InputInterface $input, OutputInterface $output){
    $output->writeln([
      'User creation: ',
      '=============',
      ''
    ]);

    $em = $this->getContainer()
               ->get('doctrine.orm.default_entity_manager')
    ;

    $user = new User();
    $password = uniqid('pwd');

    $user->setUsername($input->getArgument('username'))
         ->setPlainPassword($password)
    ;

    $Encodedpassword = $this->getContainer()
                            ->get('security.password_encoder')
                            ->encodePassword($user, $user->getPlainPassword())
    ;

    $user->setPassword($Encodedpassword);
    $user->setEmail($input->getArgument('email'));

    $user->addRole('ROLE_SUPER_ADMIN');

    $em->persist($user);
    $em->flush();

    $output->writeln('Username: '.$input->getArgument('username'));
    $output->writeln('Password: '.$password);
  }
}

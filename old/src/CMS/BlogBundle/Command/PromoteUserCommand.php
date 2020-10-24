<?php
// src/AppBundle/Command/GreetCommand.php
namespace CMS\BlogBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PromoteUserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('user:promote')
            ->setDescription('Promote user')
            ->setHelp('Allows to create user')
            ->addArgument(
                'username',
                InputArgument::OPTIONAL,
                'Who do you want promote?'
            )
            ->addArgument(
                'role',
                null,
                InputOption::VALUE_REQUIRED,
                'Role to promote user'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $doctrine = $logger = $this->getContainer()->get('doctrine');

        $name = $input->getArgument('name');

        $user = $doctrine->getManager()->getRepository('CMSBlogBundle:User')->findOneByUsername($name);

        if ($user != null && $input->getOption('role')) {

            $user->setRoles($input->getOption('role'));
            $doctrine->getManager()->persist($user);
            $doctrine->getManager()->flush();

            $text = $name.' has promoted to '.$input->getOption('role');
        } else {
            $text = $name.' has not promoted';
        }
        $output->writeln($text);
    }
}

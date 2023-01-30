<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

class SendEmailCommand extends Command
{
    protected static $defaultName = 'app:send-email';

    protected function configure()
    {
        // configure the command options and arguments here
        // ...
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // get the mailer service from the container
        $mailer = $this->getContainer()->get('mailer');

        // create an email message
        $email = (new Email())
            ->from(new Address('loic.faniry.rabehanta@esti.com', 'Greatest'))
            ->to(new Address('@example.com', 'Enao'))
            ->subject('Email TEsT LOIC')
            ->text('Email body');

        // send the email
        $mailer->send($email);
    }
}
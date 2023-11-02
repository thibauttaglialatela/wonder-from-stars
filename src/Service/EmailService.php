<?php

namespace App\Service;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailService
{
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendEmail($user)
    {
        $email = (new Email())
                ->from('admin@wonders.com')
                ->to($user->getEmail())
                ->subject('Welcome to Wonders from stars')
                ->text('Félicitation, vous venez de rejoindre les fans de wonders from stars');
        $this->mailer->send($email);
    }
}

<?php

namespace App\Service;

use App\Entity\User;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class MailService
{
    public function __construct(
        private readonly MailerInterface $mailer
    ) {}

    public function sendRegistrationEmail(User $user): void
    {
        $email= (new Email())
            ->from('schoolproject@noreply.com')
            ->to($user->getEmail())
            ->subject('Bienvenue sur notre site !')
            ->text('Bonjour ' . $user->getUserIdentifier() . ', merci de vous être inscrit sur notre site !')
        ;

        $this->mailer->send($email);
    }
}

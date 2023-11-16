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
            ->from('bienvenue@coincoin.fr')
            ->to($user->getEmail())
            ->subject('Bienvenue sur notre site !')
            ->text('Bonjour ' . $user->getUserIdentifier() . ', merci de vous être inscrit sur notre site !')
        ;

        $this->mailer->send($email);
    }

    public function sendEmail(string $email, string $subject, string $body): void
    {
        $email = (new Email())
            ->from($email)
            ->to('contact@coincoin.fr')
            ->subject('Demande de contact : ' . $subject)
            ->text($body)
        ;

        $this->mailer->send($email);
    }
}

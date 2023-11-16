<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactFormType extends AbstractType
{
    public function __construct(
        private readonly Security $security
    ) {}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if($this->security->getUser()) {
            
            /**
             * @var User $user
             */
            $user = $this->security->getUser();
            $email = $user->getEmail();
        }

        $builder
            ->add('email', EmailType::class, [
                'data' => $email ?? null,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Vous devez entrer un email',
                    ]),
                ],
            ])
            ->add('subject')
            ->add('body', TextareaType::class, [
                'attr' => ['rows' => 5],
            ])
        ;
    }
}

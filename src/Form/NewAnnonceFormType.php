<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class NewAnnonceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('description')
            ->add('price', IntegerType::class, [
                'constraints' => [
                    new Positive([
                        'message' => 'Le prix doit être un entier positif',
                    ]),
                ],
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Choisir un fichier',
                ],
                'constraints' => [
                    new File([
                        'maxSize' => '35M',
                        'maxSizeMessage' => 'Le fichier est trop volumineux ({{ size }} {{ suffix }}). ' .
                            'La taille maximum autorisée est {{ limit }} {{ suffix }}.',
                        'mimeTypes' => 'image/*',
                        'mimeTypesMessage' => 'Uniquement les fichiers {{ types }} sont autorisés',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\Annonce;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AnnonceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $categorie = null;
        if ($options['data']->getCategorie()) {
            $categorie = $options['data']->getCategorie();
        }

        $builder
            ->add('title')
            ->add('categorie', EntityType::class, [
                'placeholder' => 'Choisissez une catégorie...',
                'class' => Categorie::class,
                'choice_label' => 'name',
                'data' => $categorie,
            ])
            ->add('description',TextareaType::class, [
                'attr' => ['rows' => 4],
            ])
            ->add('price', IntegerType::class, [
                'constraints' => [
                    new Positive([
                        'message' => 'Le prix doit être un entier positif',
                    ]),
                ],
            ])
            ->add('image', FileType::class, [
                'mapped' => false,
                'required' => false,
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

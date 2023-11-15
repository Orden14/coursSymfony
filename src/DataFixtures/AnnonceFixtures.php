<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\User;
use App\Entity\Annonce;
use App\Factory\AnnonceFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class AnnonceFixtures extends Fixture implements DependentFixtureInterface
{

    public function __construct(
        private readonly AnnonceFactory $annonceFactory,
        private readonly EntityManagerInterface $entityManager
    ) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $technicien = $this->entityManager
            ->getRepository(User::class)
            ->findOneBy([
                'username' => 'technicien'
            ])
        ;

        for ($i = 0; $i < 20; $i++) {
            $manager->persist($this->generateAnnonce($faker, $technicien));
        }

        $manager->flush();
    }

    private function generateAnnonce(Generator $faker, User $owner): Annonce
    {
        return $this->annonceFactory->createAnnonce(
            $owner,
            $faker->title(),
            $faker->text(),
            $faker->numberBetween(9,999),
            'faker.jpg',
        );
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class,
        ];
    }
  }

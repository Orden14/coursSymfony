<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\User;
use App\Factory\UserFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{

    public function __construct(
        private readonly UserFactory $userFactory
    ) {}

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $manager->persist($this->generateAdminUser($faker));

        $manager->persist($this->generateTechnicienUser($faker));

        for ($i = 0; $i < 10; $i++) {
            $manager->persist($this->generateUser($faker));
        }

        $manager->flush();
    }

    private function generateAdminUser(Generator $faker): User
    {
        return $this->userFactory->createUser(
            'admin',
            $faker->firstName(),
            $faker->lastName(),
            'admin',
            'ROLE_ADMIN',
            $faker->email(),
        );
    }

    private function generateTechnicienUser(Generator $faker): User
    {
        return $this->userFactory->createUser(
            'technicien',
            $faker->firstName(),
            $faker->lastName(),
            'technicien',
            $faker->email(),
        );
    }

    private function generateUser(Generator $faker): User
    {
        return $this->userFactory->createUser(
            $faker->userName(),
            $faker->firstName(),
            $faker->lastName(),
            $faker->password(),
            $faker->email(),
        );
    }
  }

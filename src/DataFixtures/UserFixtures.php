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

        $manager->persist($this->createAdminUser($faker));

        $manager->persist($this->createTechnicienUser($faker));

        for ($i = 0; $i < 10; $i++) {
            $manager->persist($this->createUser($faker));
        }

        $manager->flush();
    }

    private function createAdminUser(Generator $faker): User
    {
        return $this->userFactory->createUser(
            'admin',
            $faker->firstName(),
            $faker->lastName(),
            'admin',
            'ROLE_ADMIN',
            $faker->email(),
            $faker->date()
        );
    }

    private function createTechnicienUser(Generator $faker): User
    {
        return $this->userFactory->createUser(
            'technicien',
            $faker->firstName(),
            $faker->lastName(),
            'technicien',
            'ROLE_USER',
            $faker->email(),
            $faker->date()
        );
    }

    private function createUser(Generator $faker): User
    {
        return $this->userFactory->createUser(
            $faker->userName(),
            $faker->firstName(),
            $faker->lastName(),
            $faker->password(),
            'ROLE_USER',
            $faker->email(),
            $faker->date()
        );
    }
  }

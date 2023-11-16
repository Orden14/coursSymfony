<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CategorieFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $manager->persist($this->generateCategorie('Voitures'));
        $manager->persist($this->generateCategorie('Ordinateurs'));

        $manager->flush();
    }

    private function generateCategorie(string $name): Categorie
    {
        return (new Categorie())->setName($name);
    }
  }

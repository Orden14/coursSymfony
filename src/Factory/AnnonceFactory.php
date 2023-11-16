<?php

namespace App\Factory;

use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Annonce;
use App\Entity\Categorie;

class AnnonceFactory
{
    public function createAnnonce(
        User $owner,
        string $title,
        string $description,
        Categorie $categorie,
        int $price,
        string $image,
    ): Annonce
    {
        $currentDateTime = new DateTimeImmutable();

        return (new Annonce())
            ->setOwner($owner)
            ->setTitle($title)
            ->setDescription($description)
            ->setCategorie($categorie)
            ->setPrice($price)
            ->setImage($image)
            ->setPostDate($currentDateTime)
        ;
    }
}

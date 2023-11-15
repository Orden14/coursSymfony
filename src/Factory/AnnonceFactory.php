<?php

namespace App\Factory;

use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Annonce;

class AnnonceFactory
{
    public function createAnnonce(
        User $owner,
        string $title,
        string $description,
        int $price,
        string $image,
    ): Annonce
    {
        $currentDateTime = new DateTimeImmutable();

        return (new Annonce())
            ->setOwner($owner)
            ->setTitle($title)
            ->setDescription($description)
            ->setPrice($price)
            ->setImage($image)
            ->setPostDate($currentDateTime)
        ;
    }
}

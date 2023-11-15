<?php

namespace App\Service;

use App\Entity\Annonce;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class AnnonceService
{
    public function __construct(
        private ParameterBagInterface $param,
    ) {}

    public function uploadImage(Annonce $annonce, UploadedFile $image): void
    {
        $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $newFilename = uniqid('', true) . '-' . $originalFilename . '.' . $image->guessExtension();

        $image->move(
            $this->param->get('image_directory'),
            $newFilename
        );

        $annonce->setImage($newFilename);
    }

    public function deleteImage(Annonce $annonce): void
    {
        $imageDir = $this->param->get('image_directory');

        unlink($imageDir . '/' . $annonce->getImage());
    }
}

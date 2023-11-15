<?php

namespace App\Controller;

use App\Entity\Annonce;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager
    ) {}


    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $annonces = $this->entityManager->getRepository(Annonce::class)->findBy(
            [],
            ['postDate' => 'DESC'],
            50
        );
    
        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }
}

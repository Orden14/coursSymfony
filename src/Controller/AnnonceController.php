<?php

namespace App\Controller;

use App\Entity\Annonce;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnonceController extends AbstractController
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

    // #[Route('/new', name: 'app_annonce_new')]
    // public function create(): Response
    // {

    // }

    // #[Route('/edit/{id}', name: 'app_annonce_edit')]
    // public function edit(Request $request): Response
    // {
    // }

    #[Route('/delete/{id}', name: 'app_annonce_delete')]
    public function delete(Request $request): Response
    {
        $annonce = $this->entityManager->getRepository(Annonce::class)->find((int) $request->get('id'));
        $this->entityManager->remove($annonce);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_index');
    }

    // #[Route('/view/{id}', name: 'app_annonce_view')]
    // public function view(Request $request): Response
    // {

    // }
}

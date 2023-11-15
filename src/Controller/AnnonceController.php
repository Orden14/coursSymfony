<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Annonce;
use App\Form\NewAnnonceFormType;
use App\Service\AnnonceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AnnonceController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
        private readonly AnnonceService $annonceService,
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

    #[Route('/new', name: 'annonce_new')]
    public function create(Request $request): Response
    {
        /** @var User $user */
        $user = $this->security->getUser();

        $annonce = new Annonce();
        $form = $this->createForm(NewAnnonceFormType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setOwner($user)
                ->setPostDate(new DateTimeImmutable())
            ;

            $image = $form->get('image')->getData();

            if ($image) {
                $this->annonceService->uploadImage($annonce, $image);
            }

            $this->entityManager->persist($annonce);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('annonce/create.html.twig', [
            'newAnnonceForm' => $form->createView(),
        ]);
    }

    // #[Route('/edit/{id}', name: 'app_annonce_edit')]
    // public function edit(Request $request): Response
    // {
    // }

    #[Route('/delete/{id}', name: 'annonce_delete')]
    public function delete(Request $request): Response
    {
        $annonce = $this->entityManager
            ->getRepository(Annonce::class)
            ->find((int) $request->get('id'))
        ;

        $this->annonceService->deleteImage($annonce);
        $this->entityManager->remove($annonce);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_index');
    }

    #[Route('/show/{id}', name: 'annonce_show')]
    public function show(Request $request): Response
    {
        $annonce = $this->entityManager
            ->getRepository(Annonce::class)
            ->find((int) $request->get('id'))
        ;

        return $this->render('annonce/show.html.twig', [
            'annonce' => $annonce,
        ]);
    }
}
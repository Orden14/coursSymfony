<?php

namespace App\Controller;

use App\Entity\User;
use DateTimeImmutable;
use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Form\AnnonceFormType;
use App\Service\AnnonceService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/annonce')]
class AnnonceController extends AbstractController
{
    public function __construct(
        private readonly Security $security,
        private readonly AnnonceService $annonceService,
        private readonly EntityManagerInterface $entityManager
    ) {}

    #[Route('/mesannonces/{id}', name: 'annonce_mesannonces')]
    #[IsGranted('ROLE_USER')]
    public function showMyAnnonces(Request $request): Response
    {
        $annonces = $this->entityManager->getRepository(Annonce::class)->findBy(
            ['owner' => $request->get('id')],
            ['postDate' => 'DESC']
        );

        if (empty($annonces)) {
            $this->addFlash(
                'error',
                'Vous n\'avez aucune annonce, nous vous avons digiré vers la page d\'accueil.'
            );

            return $this->redirectToRoute('app_index');
        }

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }

    #[Route('/list/{categorie}', name: 'annonce_find')]
    public function findAnnoncesByCategories(Request $request): Response
    {
        $categorie = $this->entityManager
            ->getRepository(Categorie::class)
            ->find($request->get('categorie'))
        ;

        $annonces = $this->entityManager
            ->getRepository(Annonce::class)
            ->findBy(
                ['categorie' => $categorie],
                ['postDate' => 'DESC']
            )
        ;

        return $this->render('annonce/index.html.twig', [
            'annonces' => $annonces,
        ]);
    }

    #[Route('/new', name: 'annonce_new')]
    #[IsGranted('ROLE_USER')]
    public function create(Request $request): Response
    {
        /** @var User $user */
        $user = $this->security->getUser();

        $annonce = new Annonce();
        $form = $this->createForm(AnnonceFormType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $annonce->setOwner($user)
                ->setPostDate(new DateTimeImmutable())
            ;

            $image = $form->get('image')->getData();

            if ($image) {
                $this->annonceService->uploadImage($annonce, $image);
            } else {
                $annonce->setImage('faker.jpg');
            }

            $this->entityManager->persist($annonce);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('annonce/manage.html.twig', [
            'annonceForm' => $form->createView(),
            'action' => 'Créer'
        ]);
    }

    #[Route('/edit/{id}', name: 'annonce_edit')]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request): Response
    {
        $annonce = $this->entityManager
            ->getRepository(Annonce::class)
            ->find((int) $request->get('id'))
        ;

        $form = $this->createForm(AnnonceFormType::class, $annonce);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('image')->getData();

            if ($image) {
                $this->annonceService->uploadImage($annonce, $image);
            }

            $this->entityManager->persist($annonce);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_index');
        }

        return $this->render('annonce/manage.html.twig', [
            'annonceForm' => $form->createView(),
            'action' => 'Modifier',
        ]);
    }

    #[Route('/delete/{id}', name: 'annonce_delete')]
    #[IsGranted('ROLE_USER')]
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

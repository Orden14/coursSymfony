<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Service\MailService;
use App\Form\ContactFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
class HomeController extends AbstractController
{
    public function __construct(
        private readonly MailService $mailService,
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

    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
            $subject = $form->get('subject')->getData();
            $body = $form->get('body')->getData();

            $this->mailService->sendEmail($email, $subject, $body);

            return $this->redirectToRoute('app_index');
        }

        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}

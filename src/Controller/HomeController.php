<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/')]
class HomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $test = [1 => 'a', 2 => 'b'];
        
        return $this->render('home/index.html.twig', [
            'projectName' => 'Cours Symfony',
        ]);
    }
}

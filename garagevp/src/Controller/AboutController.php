<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route('/a_propos', name: 'app_a_propos')]
    public function about(): Response
    {
        return $this->render('a_propos.html.twig', [
            'title' => 'À propos',
        ]);
    }
}


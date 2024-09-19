<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('index.html.twig', [
            'title' => 'Home Page',
        ]);
    }

    #[Route('/a-propos', name: 'app_a_propos')]
    public function about(): Response
    {
        return $this->render('a_propos.html.twig', [
            'title' => 'À propos',
        ]);
    }
}


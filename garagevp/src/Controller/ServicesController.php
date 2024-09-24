<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServicesController extends AbstractController
{
    #[Route('/nos-services', name: 'app_services')]
    public function services(): Response
    {
        return $this->render('nos-services.html.twig', [
            'title' => 'Nos Services',
        ]);
    }
}

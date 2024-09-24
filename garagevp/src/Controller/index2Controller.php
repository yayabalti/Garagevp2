<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class index2Controller extends AbstractController
{
    #[Route('/index2', name: 'app_home2')]
    public function index(): Response
    {
        return $this->render('index2.html.twig', [
            'title' => 'Home Page',
        ]);
    }
}
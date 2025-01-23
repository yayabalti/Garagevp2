<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class NosServicesController extends AbstractController
{
    #[Route('/nos-services', name: 'app_nos_services')]
    public function index(): Response
    {
        return $this->render('nos-services.html.twig');
    }
}
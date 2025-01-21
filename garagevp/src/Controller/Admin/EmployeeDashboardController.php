<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;
use Doctrine\ORM\EntityManagerInterface;
use App\Controller\Admin\AvisCrudController;

class EmployeeDashboardController extends AbstractDashboardController
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    #[Route('/easyemploye/dashboard', name: 'employee_dashboard')]
    public function index(): Response
    {
        // Vérifier que l'utilisateur connecté a bien le rôle 'ROLE_EMPLOYE'
        if (!$this->isGranted('ROLE_EMPLOYE')) {
            return $this->redirectToRoute('app_home');  // Rediriger si l'utilisateur n'est pas un employé
        }

        // Récupérer les avis non approuvés
        $avisNonApprouves = $this->entityManager->getRepository(Avis::class)->findBy(['approuve' => false]);

        return $this->render('employe/dashboard.html.twig', [
            'avisNonApprouves' => $avisNonApprouves
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Garage V.Parrot - Tableau de Bord Employé');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Avis');
        
        // Ajouter un lien pour les avis non approuvés (en attente de modération)
        yield MenuItem::linkToCrud('Avis à Modérer', 'fas fa-comment', Avis::class)
            ->setController(AvisCrudController::class)
            ->setAction('index');  // Affichage de l'index des avis
    }
}





<?php

namespace App\Controller\Admin;

use App\Entity\ServiceCarrosserie;
use App\Entity\ServiceEntretien;
use App\Entity\ServiceMecanique;
use App\Entity\ServiceVenteVoitureOccasion;
use App\Entity\HoraireGarage;
use App\Entity\InfoGarage;
use App\Entity\Avis;
use App\Entity\Utilisateur;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Garage V.Parrot - Administration')
            ->setFaviconPath('favicon.svg');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        
        // Services
        yield MenuItem::section('Services');
        yield MenuItem::linkToCrud('Carrosserie', 'fas fa-car', ServiceCarrosserie::class);
        yield MenuItem::linkToCrud('Entretien', 'fas fa-tools', ServiceEntretien::class);
        yield MenuItem::linkToCrud('Mécanique', 'fas fa-wrench', ServiceMecanique::class);
        yield MenuItem::linkToCrud('Vente Voitures', 'fas fa-car-side', ServiceVenteVoitureOccasion::class);
        
        // Configuration
        yield MenuItem::section('Configuration');
        yield MenuItem::linkToCrud('Horaires', 'fas fa-clock', HoraireGarage::class);
        yield MenuItem::linkToCrud('Informations', 'fas fa-info-circle', InfoGarage::class);
        
        // Gestion
        yield MenuItem::section('Gestion');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-users', Utilisateur::class);
        yield MenuItem::linkToCrud('Avis Clients', 'fas fa-star', Avis::class);
        
        yield MenuItem::linkToRoute('Retour au site', 'fas fa-home', 'app_home');
    }
}
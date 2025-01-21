<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use App\Entity\User;
use App\Entity\InformationGarage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;

class AdminDashboardController extends AbstractDashboardController
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin_dashboard')]
    public function index(): Response
    {
        // On récupère l'utilisateur connecté via le service Security
        $user = $this->security->getUser();

        // Vous pouvez récupérer des données pour l'admin si nécessaire
        // Par exemple, afficher des statistiques ou des notifications

        return $this->render('admin/dashboard.html.twig', [
            'user' => $user
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Garage V.Parrot - Administration');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Services');
        
        yield MenuItem::subMenu('Mécanique', 'fas fa-wrench')->setSubItems([
            MenuItem::linkToCrud('Moteur', 'fas fa-cog', Service::class)
                ->setController(ServiceMecaniqueCrudController::class),
            MenuItem::linkToCrud('Freinage', 'fas fa-brake', Service::class)
                ->setController(ServiceMecaniqueCrudController::class),
            MenuItem::linkToCrud('Échappement', 'fas fa-wind', Service::class)
                ->setController(ServiceMecaniqueCrudController::class),
            MenuItem::linkToCrud('Suspension', 'fas fa-car', Service::class)
                ->setController(ServiceMecaniqueCrudController::class),
            MenuItem::linkToCrud('Pneumatique', 'fas fa-circle', Service::class)
                ->setController(ServiceMecaniqueCrudController::class),
        ]);

        yield MenuItem::subMenu('Entretien', 'fas fa-tools')->setSubItems([
            MenuItem::linkToCrud('Vidange et filtres', 'fas fa-oil-can', Service::class)
                ->setController(ServiceEntretienCrudController::class),
            MenuItem::linkToCrud('Pneus et freins', 'fas fa-car-side', Service::class)
                ->setController(ServiceEntretienCrudController::class),
            MenuItem::linkToCrud('Diagnostic électrique', 'fas fa-bolt', Service::class)
                ->setController(ServiceEntretienCrudController::class),
            MenuItem::linkToCrud('Batterie', 'fas fa-car-battery', Service::class)
                ->setController(ServiceEntretienCrudController::class),
        ]);

        yield MenuItem::subMenu('Carrosserie', 'fas fa-car')->setSubItems([
            MenuItem::linkToCrud('Ponçage et peinture', 'fas fa-paint-roller', Service::class)
                ->setController(ServiceCarrosserieCrudController::class),
            MenuItem::linkToCrud('Réparation carrosserie', 'fas fa-hammer', Service::class)
                ->setController(ServiceCarrosserieCrudController::class),
            MenuItem::linkToCrud('Remplacement d\'éléments', 'fas fa-tools', Service::class)
                ->setController(ServiceCarrosserieCrudController::class),
        ]);

        yield MenuItem::section('Administration');

        yield MenuItem::linkToCrud('Employés', 'fas fa-users', User::class)
            ->setController(UserCrudController::class);

        yield MenuItem::linkToCrud('Informations Garage', 'fas fa-info-circle', InformationGarage::class)
            ->setController(InformationGarageCrudController::class);
    }
}

<?php
namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

class AdminDashboardController extends AbstractDashboardController
{
   private $security;

   public function __construct(Security $security)
   {
       $this->security = $security;
   }

   #[Route('/admin', name: 'admin_dashboard')]
   public function index(): Response
   {
       if (!$this->security->isGranted('ROLE_ADMIN')) {
           throw $this->createAccessDeniedException();
       }
       return $this->render('admin/dashboard.html.twig');
   }

   public function configureDashboard(): Dashboard
   {
       return Dashboard::new()->setTitle('Administration Garage V.Parrot');
   }

   public function configureMenuItems(): iterable
   {
       yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

       yield MenuItem::section('Services');
       
       yield MenuItem::subMenu('Mécanique', 'fas fa-wrench')->setSubItems([
           MenuItem::linkToRoute('Moteur', 'fas fa-cog', 'admin_dashboard'),
           MenuItem::linkToRoute('Freinage', 'fas fa-brake', 'admin_dashboard'),
           MenuItem::linkToRoute('Échappement', 'fas fa-wind', 'admin_dashboard'),
           MenuItem::linkToRoute('Suspension', 'fas fa-car', 'admin_dashboard'),
           MenuItem::linkToRoute('Pneumatique', 'fas fa-circle', 'admin_dashboard'),
       ]);

       yield MenuItem::subMenu('Entretien', 'fas fa-tools')->setSubItems([
           MenuItem::linkToRoute('Vidange et filtres', 'fas fa-oil-can', 'admin_dashboard'),
           MenuItem::linkToRoute('Pneus et freins', 'fas fa-car-side', 'admin_dashboard'),
           MenuItem::linkToRoute('Diagnostic électrique', 'fas fa-bolt', 'admin_dashboard'),
           MenuItem::linkToRoute('Batterie', 'fas fa-car-battery', 'admin_dashboard'),
       ]);

       yield MenuItem::subMenu('Carrosserie', 'fas fa-car')->setSubItems([
           MenuItem::linkToRoute('Ponçage et peinture', 'fas fa-paint-roller', 'admin_dashboard'),
           MenuItem::linkToRoute('Réparation carrosserie', 'fas fa-hammer', 'admin_dashboard'),
           MenuItem::linkToRoute('Remplacement d\'éléments', 'fas fa-tools', 'admin_dashboard'),
       ]);

       yield MenuItem::section('Administration');

       if ($this->security->isGranted('ROLE_ADMIN')) {
           yield MenuItem::linkToCrud('Employés', 'fas fa-users', User::class)
               ->setController(UserCrudController::class);
       }

       yield MenuItem::linkToRoute('Informations Garage', 'fas fa-info-circle', 'admin_dashboard');
   }
}
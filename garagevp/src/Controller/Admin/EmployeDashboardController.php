<?php

namespace App\Controller\Admin;


use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/easyemploye')]
class EmployeDashboardController extends AbstractDashboardController
{
   
   public function __construct(private EntityManagerInterface $entityManager)
   {
   }

   
   #[Route('/dashboard', name: 'employe_dashboard')]
   public function index(): Response
   {
       // Récupération de toutes les voitures depuis la base de données
       $cars = $this->entityManager->getRepository(Car::class)->findAll();
       
       // Gestion des messages flash en fonction de la présence ou non de voitures
       if (!$cars) {
           $this->addFlash('warning', 'Aucun véhicule trouvé dans le stock.');
       } else {
           $this->addFlash('success', count($cars) . ' véhicules disponibles.');
       }

       // Rendu du template avec les données des voitures
       return $this->render('employe/dashboard.html.twig', [
           'cars' => $cars
       ]);
   }

   // Configuration du dashboard EasyAdmin
   public function configureDashboard(): Dashboard
   {
       // Définition du titre de l'interface d'administration
       return Dashboard::new()->setTitle('Interface Employé');
   }

   // Configuration des éléments du menu
   public function configureMenuItems(): iterable
   {
       // Ajout des liens dans le menu latéral
       yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home'); // Lien vers le tableau de bord
       yield MenuItem::linkToCrud('Voitures', 'fas fa-car', Car::class); // Lien vers la gestion des voitures
   }
}










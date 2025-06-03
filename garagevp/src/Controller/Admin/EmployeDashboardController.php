<?php

//  namespace App\Controller\Admin;

//  use App\Entity\Car;
//  use App\Entity\Review;
//  use Doctrine\ORM\EntityManagerInterface;
//  use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
//  use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
//  use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
//  use Symfony\Component\HttpFoundation\Response;
//  use Symfony\Component\Routing\Annotation\Route;

//  #[Route('/easyemploye')]
//  class EmployeDashboardController extends AbstractDashboardController
//  {
//     public function __construct(private EntityManagerInterface $entityManager)
//     {
//     }

//     #[Route('/dashboard', name: 'employe_dashboard')]
//     public function index(): Response
//     {
//         // Récupération des voitures et des avis en attente
//         $cars = $this->entityManager->getRepository(Car::class)->findAll();
//         $pendingReviews = $this->entityManager->getRepository(Review::class)->findBy(['approved' => false]);
       
//         // Gestion des messages flash
//         if (!$cars) {
//             $this->addFlash('warning', 'Aucun véhicule trouvé dans le stock.');
//         } else {
//             $this->addFlash('success', count($cars) . ' véhicules disponibles.');
//         }

//         if (count($pendingReviews) > 0) {
//             $this->addFlash('warning', count($pendingReviews) . ' avis en attente de validation');
//         }

//         // Rendu du template avec les données des voitures et des avis
//         return $this->render('employe/dashboard.html.twig', [
//             'cars' => $cars,
//             'pendingReviews' => $pendingReviews
//         ]);
//     }

//     // Configuration du dashboard EasyAdmin
//     public function configureDashboard(): Dashboard
//     {
//         // Définition du titre de l'interface d'administration
//         return Dashboard::new()->setTitle('Interface Employé');
//     }

//     // Configuration des éléments du menu
//     public function configureMenuItems(): iterable
//     {
//         // Ajout des liens dans le menu latéral
//         yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
//         yield MenuItem::linkToCrud('Voitures', 'fas fa-car', Car::class);
//         yield MenuItem::linkToCrud('Avis', 'fas fa-comment', Review::class);
//     }
//  }





 namespace App\Controller\Admin;

 use App\Entity\Car;
 use App\Entity\User;
 use App\Entity\Review;
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
        try {
            error_log('Début de la récupération des données du dashboard');
           
            // Récupération des voitures et des avis en attente
            $cars = $this->entityManager->getRepository(Car::class)
                ->createQueryBuilder('c')
                ->orderBy('c.id', 'DESC')
                ->getQuery()
                ->getResult();
           
            error_log('Nombre de voitures trouvées : ' . count($cars));
           
            $pendingReviews = $this->entityManager->getRepository(Review::class)
                ->findBy(['approved' => false]);
           
            error_log('Nombre d\'avis en attente : ' . count($pendingReviews));

            // Gestion des messages flash
            if (!$cars) {
                $this->addFlash('warning', 'Aucun véhicule trouvé dans le stock.');
            } else {
                $this->addFlash('success', count($cars) . ' véhicules disponibles.');
            }

           if (count($pendingReviews) > 0) {
                $this->addFlash('warning', count($pendingReviews) . ' avis en attente de validation');
            }

            error_log('Rendu du dashboard avec les données récupérées');
           
            // Rendu du template avec les données
            return $this->render('employe/dashboard.html.twig', [
                'cars' => $cars,
                'pendingReviews' => $pendingReviews
            ]);
           
        } catch (\Exception $e) {
            error_log('Erreur dans le dashboard : ' . $e->getMessage());
            throw $e;
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Interface Employé')
            ->renderContentMaximized();
   }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
       
        yield MenuItem::section('Gestion des véhicules');
        yield MenuItem::linkToCrud('Liste des voitures', 'fas fa-car', Car::class);
        yield MenuItem::linkToCrud('Ajouter une voiture', 'fas fa-plus', Car::class)
            ->setAction('new');
       
        yield MenuItem::section('Gestion des avis');
        yield MenuItem::linkToCrud('Avis clients', 'fas fa-comment', Review::class);
       
       
    }
 }









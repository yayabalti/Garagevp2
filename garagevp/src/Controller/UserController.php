<?php

namespace App\Controller;

use App\Service\FirebaseService; // Assurez-vous d'importer correctement votre service Firebase
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted; // Pour sécuriser les actions
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
    private $firebaseService;

    // Injection du service Firebase via le constructeur
    public function __construct(FirebaseService $firebaseService)
    {
        $this->firebaseService = $firebaseService;
    }

    #[Route('/user', name: 'app_user')]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $roles = $user->getRoles();
        $isSuperAdmin = in_array('ROLE_SUPER_ADMIN', $roles);
        $isAdmin = in_array('ROLE_ADMIN', $roles);
        $isVisitor = in_array('ROLE_VISITOR', $roles);

        if ($isSuperAdmin) {
            return $this->render('user/index.html.twig', [
                'controller_name' => 'UserController',
                'role' => 'Super Administrateur',
            ]);
        }

        if ($isAdmin) {
            return $this->render('user/index.html.twig', [
                'controller_name' => 'UserController',
                'role' => 'Employé',
            ]);
        }

        if ($isVisitor) {
            return $this->render('user/index.html.twig', [
                'controller_name' => 'UserController',
                'role' => 'Visiteur',
            ]);
        }

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'role' => 'Utilisateur',
        ]);
    }

    #[Route('/admin/super', name: 'super_admin_dashboard')]
    #[IsGranted('ROLE_SUPER_ADMIN')]
    public function superAdminDashboard(): Response
    {
        return $this->render('admin/super_dashboard.html.twig', [
            'controller_name' => 'SuperAdminController',
        ]);
    }

    #[Route('/admin/employe', name: 'admin_employe_dashboard')]
    #[IsGranted('ROLE_ADMIN')]
    public function employeDashboard(): Response
    {
        return $this->render('admin/employe_dashboard.html.twig', [
            'controller_name' => 'EmployeController',
        ]);
    }

    // Route pour permettre aux visiteurs de laisser un avis
    #[Route('/leave-avis', name: 'leave_avis')]
    public function leaveAvis(Request $request): Response
    {
        // Récupérer les données du formulaire (avis du visiteur)
        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $email = $request->request->get('email');
        $avis = $request->request->get('avis');
        $note = $request->request->get('note');

        // Envoi de l'avis à Firebase pour validation
        $this->firebaseService->saveAvis([
            'nom' => $nom,
            'prenom' => $prenom,
            'email' => $email,
            'avis' => $avis,
            'note' => $note,
            'date' => new \DateTime(),
            'statut' => 'en attente', // Par défaut, "en attente" pour validation
        ]);

        return $this->render('avis/success.html.twig', [
            'message' => 'Votre avis a été soumis avec succès et est en attente de validation.',
        ]);
    }
}




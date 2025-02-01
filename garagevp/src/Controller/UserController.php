<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserController extends AbstractController
{
    
    private $entityManager;
    private $passwordHasher;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->entityManager = $entityManager;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/api/users', name: 'api_users_get', methods: ['GET'])]
    public function getUsers(): JsonResponse
    {
        $users = $this->entityManager->getRepository(User::class)->findAll();
        
        $userData = [];
        foreach ($users as $user) {
            $userData[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'roles' => $user->getRoles(),
                'firstname' => $user->getFirstname(),
                'lastname' => $user->getLastname()
            ];
        }

        return $this->json($userData);
    }

    // Routes API
    #[Route('/api/users', name: 'api_users_create', methods: ['POST'])]
    public function createUser(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // Validation des données
        if (!isset($data['email']) || !isset($data['password'])) {
            return new JsonResponse(['message' => 'Missing required fields'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Vérifier si l'utilisateur existe déjà
        $existingUser = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            return new JsonResponse(['message' => 'User already exists'], JsonResponse::HTTP_CONFLICT);
        }

        // Créer le nouvel utilisateur
        $user = new User();
        $user->setEmail($data['email']);
        
        // Hasher le mot de passe
        $hashedPassword = $this->passwordHasher->hashPassword($user, $data['password']);
        $user->setPassword($hashedPassword);

        // Définir les rôles
        $roles = $data['roles'] ?? ['ROLE_USER'];
        $user->setRoles($roles);

        // Ajouter d'autres champs si fournis
        if (isset($data['firstname'])) $user->setFirstname($data['firstname']);
        if (isset($data['lastname'])) $user->setLastname($data['lastname']);

        try {
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return new JsonResponse([
                'message' => 'User created successfully',
                'id' => $user->getId()
            ], JsonResponse::HTTP_CREATED);
        } catch (\Exception $e) {
            return new JsonResponse([
                'message' => 'Error creating user',
                'error' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    // Routes Web existantes
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

    #[Route('/leave-avis', name: 'leave_avis')]
    public function leaveAvis(Request $request): Response
    {
        if ($request->isMethod('POST')) {
            // Les données seront envoyées à Firebase via JavaScript
            return $this->render('avis/success.html.twig', [
                'message' => 'Votre avis a été soumis avec succès et est en attente de validation.',
            ]);
        }

        // Afficher le formulaire
        return $this->render('avis/form.html.twig', [
            'message' => 'Laissez votre avis',
        ]);
    }
}




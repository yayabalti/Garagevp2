<?php

namespace App\Controller;

use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class JwtAuthController extends AbstractController
{
    private $jwtManager;
    private $entityManager;


    public function __construct(JWTTokenManagerInterface $jwtManager, EntityManagerInterface $entityManager)
    {
        $this->jwtManager = $jwtManager;
        $this->entityManager = $entityManager;
    }


    //Endpoint de connexion permettant d'obtenir un token JWT.
     
    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
     
    public function login(Request $request): JsonResponse
    {
        // Récupération des données JSON envoyées dans la requête
        $data = json_decode($request->getContent(), true);
        
        // Vérification du format JSON
        if (!$data) {
            return new JsonResponse(['message' => 'Invalid JSON format'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Vérification que les champs username et password sont bien fournis
        if (empty($data['username']) || empty($data['password'])) {
            return new JsonResponse(['message' => 'Username and password are required'], JsonResponse::HTTP_BAD_REQUEST);
        }

        // Recherche de l'utilisateur en base de données par son email
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $data['username']]);

        // Si l'utilisateur n'existe pas, renvoyer une erreur 401 (Unauthorized)
        if (!$user) {
            return new JsonResponse(['message' => 'User not found'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        // Vérification du mot de passe en comparant avec le hash stocké en base
        if (!password_verify($data['password'], $user->getPassword())) {
            return new JsonResponse(['message' => 'Invalid credentials'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        try {
            // Génération du token JWT pour l'utilisateur authentifié
            $token = $this->jwtManager->create($user);
            
            // Retourner le token JWT en réponse
            return new JsonResponse(['token' => $token]);
        } catch (\Exception $e) {
            // En cas d'erreur, renvoyer un message d'erreur avec un statut 500 (Internal Server Error)
            return new JsonResponse(['message' => $e->getMessage()], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}


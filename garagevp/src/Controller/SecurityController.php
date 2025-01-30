<?php

// namespace App\Controller;

// use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\Response;
// use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

// class SecurityController extends AbstractController
// {
//     #[Route('/login', name: 'app_login')]
//     public function login(AuthenticationUtils $authenticationUtils): Response
//     {
//         if ($this->getUser()) {
//             return $this->redirectToRoute('app_home');
//         }

//         $error = $authenticationUtils->getLastAuthenticationError();
//         $lastUsername = $authenticationUtils->getLastUsername();

//         return $this->render('security/login.html.twig', [
//             'last_username' => $lastUsername,
//             'error' => $error,
//         ]);
//     }

//     #[Route('/logout', name: 'app_logout', methods: ['GET'])]
//     public function logout(): void
//     {
//     }
// }


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est déjà connecté, le rediriger vers la page d'accueil
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }

        // Récupérer les erreurs de connexion (si présentes)
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        // Si une erreur existe, un message d'erreur sera affiché
        if ($error) {
            $this->addFlash('error', 'Nom d\'utilisateur ou mot de passe incorrect.');
        }

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route('/logout', name: 'app_logout', methods: ['GET'])]
    public function logout(): void
    {
        // Ce contrôleur ne fait rien car Symfony gère la déconnexion automatiquement
    }
}

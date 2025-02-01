<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\BadCredentialsException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Psr\Log\LoggerInterface;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
    use TargetPathTrait;

    public const LOGIN_ROUTE = 'app_login';

    public function __construct(
        private LoggerInterface $logger,
        private UrlGeneratorInterface $urlGenerator,
        private EntityManagerInterface $entityManager,
        private UserRepository $userRepository,
        private UserPasswordHasherInterface $passwordHasher
    ) {
    }

    public function authenticate(Request $request): Passport
    {
        // Vérifie si la requête est au format JSON
        if ($request->headers->get('Content-Type') === 'application/json') {
            $data = json_decode($request->getContent(), true);
            $email = $data['email'] ?? '';
            $password = $data['password'] ?? '';
        } else {
            // Récupère les paramètres classiques dans le formulaire si ce n'est pas du JSON
            $email = $request->request->get('email', '');
            $password = $request->request->get('password', '');
        }

        // Log détaillé de la tentative de connexion
        $this->logger->info('Tentative de connexion', [
            'email' => $email,
            'password_length' => strlen($password)
        ]);

        // Vérification si l'email et le mot de passe sont vides
        if (empty($email) || empty($password)) {
            $this->logger->warning('Connexion échouée : Email ou mot de passe vide');
            throw new CustomUserMessageAuthenticationException('Email et mot de passe requis.');
        }

        // Vérifie si l'email a un format valide
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->logger->warning('Connexion échouée : Format email invalide', ['email' => $email]);
            throw new CustomUserMessageAuthenticationException('Format d\'email invalide.');
        }

        // Vérifie si le mot de passe contient au moins un caractère spécial
        if (!preg_match('/[!@#$%^&*()_+\-=\[\]{};\'\\:"|,.<>\/?]+/', $password)) {
            $this->logger->warning('Connexion échouée : Mot de passe sans caractère spécial', ['email' => $email]);
            throw new CustomUserMessageAuthenticationException('Le mot de passe doit contenir au moins un caractère spécial.');
        }

        // Enregistre l'email dans la session pour le dernier nom d'utilisateur
        $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

        return new Passport(
            new UserBadge($email, function($email) use ($password) {
                // Recherche l'utilisateur dans la base de données
                $user = $this->userRepository->findOneBy(['email' => $email]);

                // Log de l'état de l'utilisateur trouvé
                $this->logger->info('Vérification utilisateur', [
                    'user_found' => $user !== null,
                    'user_email' => $email,
                    'user_roles' => $user ? $user->getRoles() : null,
                    'user_active' => $user ? $user->isActive() : null
                ]);

                // Si l'utilisateur n'existe pas, on génère une erreur d'authentification
                if (!$user) {
                    $this->logger->warning('Connexion échouée : Utilisateur non trouvé', ['email' => $email]);
                    throw new BadCredentialsException('Utilisateur non trouvé.');
                }

                // Vérification du mot de passe haché
                if (!$this->passwordHasher->isPasswordValid($user, $password)) {
                    $this->logger->warning('Connexion échouée : Mauvais mot de passe', ['email' => $email]);
                    throw new BadCredentialsException('Mauvais mot de passe.');
                }

                // Vérification si le compte est verrouillé
                if ($user->isLocked()) {
                    // Vérifie si le temps de verrouillage est passé
                    $lastFailedAttempt = $user->getLastFailedLoginAt();
                    $unlockTime = $lastFailedAttempt ? $lastFailedAttempt->modify('+15 minutes') : null;

                    // Si le compte est toujours verrouillé, on l'empêche de se connecter
                    if ($unlockTime && $unlockTime > new \DateTimeImmutable()) {
                        $this->logger->warning('Connexion échouée : Compte verrouillé', ['email' => $email]);
                        $remainingTime = $unlockTime->getTimestamp() - time();
                        throw new CustomUserMessageAuthenticationException(
                            sprintf('Trop de tentatives échouées. Réessayez dans 15 minutes.', ceil($remainingTime / 60))
                        );
                    }

                    // Déverrouille automatiquement le compte si le temps de verrouillage est passé
                    $user->setIsLocked(false);
                    $user->setLoginAttempts(0);  // Réinitialise les tentatives de connexion
                    $this->entityManager->flush();  // Sauvegarde l'état de l'utilisateur
                }

                return $user;  // Renvoie l'utilisateur trouvé
            }),
            new PasswordCredentials($password),  // Crée les informations de passe pour la validation
            [new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token'))]  // Vérification CSRF pour éviter les attaques
        );
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        $user = $token->getUser();
        if ($user instanceof User) {
            $this->logger->info('Connexion réussie', [
                'email' => $user->getEmail(),
                'roles' => $user->getRoles()
            ]);
            $user->setLastLoginAt(new \DateTimeImmutable());
            $this->entityManager->flush();
        }

        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->urlGenerator->generate('app_home'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
    {
        $this->logger->warning('Échec de connexion', [
            'message' => $exception->getMessage()
        ]);

        // Enregistre l'échec de tentative
        $email = $request->request->get('email', '');
        $user = $this->userRepository->findOneBy(['email' => $email]);

        if ($user) {
            $user->setLoginAttempts($user->getLoginAttempts() + 1);
            $user->setLastFailedLoginAt(new \DateTimeImmutable());

            // Verrouille le compte si trop d'échecs
            if ($user->getLoginAttempts() >= 3) {
                $user->setIsLocked(true);
                $this->logger->warning('Compte verrouillé après trop d\'échecs', ['email' => $email]);
            }

            $this->entityManager->flush();
        }

        return parent::onAuthenticationFailure($request, $exception);
    }

    protected function getLoginUrl(Request $request): string
    {
        return $this->urlGenerator->generate(self::LOGIN_ROUTE);
    }
}



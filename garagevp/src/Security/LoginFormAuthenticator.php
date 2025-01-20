<?php

namespace App\Security;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractLoginFormAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\SecurityRequestAttributes;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractLoginFormAuthenticator
{
   use TargetPathTrait;

   public const LOGIN_ROUTE = 'app_login';

   public function __construct(
       private UrlGeneratorInterface $urlGenerator,
       private EntityManagerInterface $entityManager,
       private UserRepository $userRepository
   ) {
   }

   public function supports(Request $request): bool
   {
       return self::LOGIN_ROUTE === $request->attributes->get('_route')
           && $request->isMethod('POST');
   }

   public function authenticate(Request $request): Passport
   {
       $email = $request->request->get('email', '');
       $password = $request->request->get('password', '');

       // Validation de l'email
       if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
           throw new CustomUserMessageAuthenticationException('Format d\'email invalide.');
       }

       // Vérification du verrouillage
       $user = $this->userRepository->findOneBy(['email' => $email]);
       if ($user && $user->isLocked()) {
           throw new CustomUserMessageAuthenticationException('Compte temporairement bloqué. Veuillez réessayer dans quelques minutes.');
       }

       $request->getSession()->set(SecurityRequestAttributes::LAST_USERNAME, $email);

       return new Passport(
           new UserBadge($email),
           new PasswordCredentials($password),
           [
               new CsrfTokenBadge('authenticate', $request->request->get('_csrf_token')),
           ]
       );
   }

   public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
   {
       $user = $token->getUser();
       if ($user instanceof User) {
           $user->setLastLoginAt(new \DateTimeImmutable());
           $user->resetLoginAttempts();
           $this->entityManager->flush();
       }

       if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName)) {
           return new RedirectResponse($targetPath);
       }

       return new RedirectResponse($this->urlGenerator->generate('app_home'));
   }

   public function onAuthenticationFailure(Request $request, AuthenticationException $exception): Response
   {
       $email = $request->request->get('email');
       $user = $this->userRepository->findOneBy(['email' => $email]);
       
       if ($user) {
           $user->incrementLoginAttempts();
           $this->entityManager->flush();
       }

       return parent::onAuthenticationFailure($request, $exception);
   }

   protected function getLoginUrl(Request $request): string
   {
       return $this->urlGenerator->generate(self::LOGIN_ROUTE);
   }
}
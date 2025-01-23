<?php
namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: "users")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
   #[ORM\Id]
   #[ORM\GeneratedValue]
   #[ORM\Column(type: "integer")]
   private ?int $id = null;

   #[ORM\Column(length: 180, unique: true)]
   private ?string $email = null;

   #[ORM\Column(type: "json")]
   private array $roles = [];

   #[ORM\Column(type: "string")]
   private string $password;

   #[ORM\Column(name: "first_name", type: "string", length: 255, nullable: true)]
   private ?string $firstName = null;

   #[ORM\Column(name: "last_name", type: "string", length: 255, nullable: true)]
   private ?string $lastName = null;

   #[ORM\Column(name: "created_at", type: "datetime_immutable", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
   private \DateTimeImmutable $createdAt;

   #[ORM\Column(name: "last_login_at", type: "datetime_immutable", nullable: true)]
   private ?\DateTimeImmutable $lastLoginAt = null;

   #[ORM\Column(name: "is_active", type: "boolean", options: ["default" => true])]
   private bool $isActive = true;

   #[ORM\Column(name: "login_attempts", type: "integer", options: ["default" => 0])]
   private int $loginAttempts = 0;

   #[ORM\Column(name: "is_locked", type: "boolean", options: ["default" => false])]
   private bool $isLocked = false;

   /**
    * Constructeur qui initialise la date de création
    */
   public function __construct()
   {
       $this->createdAt = new \DateTimeImmutable('now');
   }

   /**
    * Retourne l'identifiant unique de l'utilisateur
    */
   public function getId(): ?int
   {
       return $this->id;
   }

   /**
    * Retourne l'adresse email de l'utilisateur
    */
   public function getEmail(): ?string
   {
       return $this->email;
   }

   /**
    * Définit l'adresse email de l'utilisateur
    */
   public function setEmail(string $email): self
   {
       $this->email = $email;
       return $this;
   }

   /**
    * Retourne l'identifiant utilisé pour l'authentification (email)
    */
   public function getUserIdentifier(): string
   {
       return (string) $this->email;
   }

   /**
    * Retourne les rôles de l'utilisateur avec ROLE_USER par défaut.
    * Ajoute ROLE_EMPLOYE si l'utilisateur est un employé.
    */
   public function getRoles(): array
   {
       $roles = $this->roles;

       // Ajouter les rôles de base
       $roles[] = 'ROLE_USER';

       // Si l'utilisateur est un employé, ajouter ROLE_EMPLOYE
       if (in_array('ROLE_EMPLOYE', $this->roles)) {
           $roles[] = 'ROLE_EMPLOYE';
       }

       // Retourner les rôles uniques
       return array_unique($roles);
   }

   /**
    * Définit les rôles de l'utilisateur (admin ou employé)
    * 
    * Rôle admin => ROLE_ADMIN
    * Rôle employé => ROLE_EMPLOYE
    */
   public function setRoles(array $roles): self
   {
       $this->roles = $roles;
       return $this;
   }

   /**
    * Retourne le mot de passe hashé
    */
   public function getPassword(): string
   {
       return $this->password;
   }

   /**
    * Définit le mot de passe hashé
    */
   public function setPassword(string $password): self
   {
       $this->password = $password;
       return $this;
   }

   /**
    * Efface les données sensibles
    */
   public function eraseCredentials(): void
   {
       // Méthode requise par l'interface UserInterface
   }

   /**
    * Retourne le prénom de l'utilisateur
    */
   public function getFirstName(): ?string
   {
       return $this->firstName;
   }

   /**
    * Définit le prénom de l'utilisateur
    */
   public function setFirstName(?string $firstName): self
   {
       $this->firstName = $firstName;
       return $this;
   }

   /**
    * Retourne le nom de famille de l'utilisateur
    */
   public function getLastName(): ?string
   {
       return $this->lastName;
   }

   /**
    * Définit le nom de famille de l'utilisateur
    */
   public function setLastName(?string $lastName): self
   {
       $this->lastName = $lastName;
       return $this;
   }

   /**
    * Retourne la date de création du compte
    */
   public function getCreatedAt(): \DateTimeImmutable
   {
       return $this->createdAt;
   }

   /**
    * Retourne la dernière date de connexion
    */
   public function getLastLoginAt(): ?\DateTimeImmutable
   {
       return $this->lastLoginAt;
   }

   /**
    * Définit la dernière date de connexion
    */
   public function setLastLoginAt(\DateTimeImmutable $lastLoginAt): self
   {
       $this->lastLoginAt = $lastLoginAt;
       return $this;
   }

   /**
    * Vérifie si le compte est actif
    */
   public function isActive(): bool
   {
       return $this->isActive;
   }

   /**
    * Définit si le compte est actif
    */
   public function setIsActive(bool $isActive): self
   {
       $this->isActive = $isActive;
       return $this;
   }

   /**
    * Retourne le nombre de tentatives de connexion échouées
    */
   public function getLoginAttempts(): int
   {
       return $this->loginAttempts;
   }

   /**
    * Incrémente le compteur de tentatives de connexion
    * Verrouille le compte après 3 tentatives échouées
    */
   public function incrementLoginAttempts(): void
   {
       $this->loginAttempts++;
       if ($this->loginAttempts >= 3) {
           $this->isLocked = true;
       }
   }

   /**
    * Réinitialise le compteur de tentatives et déverrouille le compte
    */
   public function resetLoginAttempts(): void
   {
       $this->loginAttempts = 0;
       $this->isLocked = false;
   }

   /**
    * Vérifie si le compte est verrouillé
    */
   public function isLocked(): bool
   {
       return $this->isLocked;
   }

   /**
    * Définit si le compte est verrouillé
    */
   public function setLocked(bool $isLocked): self
   {
       $this->isLocked = $isLocked;
       return $this;
   }

   /**
    * Retourne la représentation string de l'utilisateur (email)
    */
   public function __toString(): string
   {
       return $this->email ?? '';
   }

}

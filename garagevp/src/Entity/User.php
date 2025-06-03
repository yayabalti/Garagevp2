<?php

// namespace App\Entity;


// use App\Repository\UserRepository;
// use Doctrine\ORM\Mapping as ORM;
// use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
// use Symfony\Component\Security\Core\User\UserInterface;


// #[ORM\Entity(repositoryClass: UserRepository::class)]
// #[ORM\Table(name: "users")]
// class User implements UserInterface, PasswordAuthenticatedUserInterface
// {
//     // Identifiant unique de l'utilisateur
//     #[ORM\Id]
//     #[ORM\GeneratedValue]
//     #[ORM\Column(type: "integer")]
//     private ?int $id = null;

//     // Adresse email unique de l'utilisateur
//     #[ORM\Column(length: 180, unique: true)]
//     private ?string $email = null;

//     // Liste des rôles attribués à l'utilisateur (exemple : ROLE_USER, ROLE_ADMIN, ROLE_EMPLOYE)
//     #[ORM\Column(type: "json")]
//     private array $roles = [];

//     // Mot de passe hashé de l'utilisateur
//     #[ORM\Column(type: "string")]
//     private string $password;

//     // Prénom de l'utilisateur
//     #[ORM\Column(name: "first_name", type: "string", length: 255, nullable: true)]
//     private ?string $firstName = null;

//     // Nom de famille de l'utilisateur
//     #[ORM\Column(name: "last_name", type: "string", length: 255, nullable: true)]
//     private ?string $lastName = null;

//     // Date et heure de création du compte utilisateur (initialisée automatiquement)
//     #[ORM\Column(name: "created_at", type: "datetime_immutable", nullable: false, options: ["default" => "CURRENT_TIMESTAMP"])]
//     private \DateTimeImmutable $createdAt;

//     // Dernière date et heure de connexion réussie de l'utilisateur
//     #[ORM\Column(name: "last_login_at", type: "datetime_immutable", nullable: true)]
//     private ?\DateTimeImmutable $lastLoginAt = null;

//     // Statut du compte (actif ou désactivé)
//     #[ORM\Column(name: "is_active", type: "boolean", options: ["default" => true])]
//     private bool $isActive = true;

//     // Nombre de tentatives de connexion échouées
//     #[ORM\Column(name: "login_attempts", type: "integer", options: ["default" => 0])]
//     private int $loginAttempts = 0;

//     // Indicateur si le compte est verrouillé après plusieurs tentatives échouées
//     #[ORM\Column(name: "is_locked", type: "boolean", options: ["default" => false])]
//     private bool $isLocked = false;

//     // Date et heure où le compte a été verrouillé (null si non verrouillé)
//     #[ORM\Column(name: "locked_at", type: "datetime_immutable", nullable: true)]
//     private ?\DateTimeImmutable $lockedAt = null;

//     /**
//      * Constructeur qui initialise la date de création du compte
//      */
//     public function __construct()
//     {
//         $this->createdAt = new \DateTimeImmutable('now');
//     }

//     // Retourne l'identifiant unique de l'utilisateur
//     public function getId(): ?int
//     {
//         return $this->id;
//     }

//     // Retourne l'adresse email de l'utilisateur
//     public function getEmail(): ?string
//     {
//         return $this->email;
//     }

//     // Définit l'adresse email de l'utilisateur
//     public function setEmail(string $email): self
//     {
//         $this->email = $email;
//         return $this;
//     }

//     // Retourne l'identifiant utilisé pour l'authentification (email)
//     public function getUserIdentifier(): string
//     {
//         return (string) $this->email;
//     }

//     // Retourne les rôles attribués à l'utilisateur
//     public function getRoles(): array
//     {
//         $roles = $this->roles;

//         // Ajoute un rôle par défaut : ROLE_USER
//         $roles[] = 'ROLE_USER';

//         // Si l'utilisateur a un rôle employé, l'ajouter à la liste
//         if (in_array('ROLE_EMPLOYE', $this->roles)) {
//             $roles[] = 'ROLE_EMPLOYE';
//         }

//         return array_unique($roles); // Évite les doublons
//     }

//     // Définit les rôles de l'utilisateur
//     public function setRoles(array $roles): self
//     {
//         $this->roles = $roles;
//         return $this;
//     }

//     // Retourne le mot de passe hashé
//     public function getPassword(): string
//     {
//         return $this->password;
//     }

//     // Définit le mot de passe hashé
//     public function setPassword(string $password): self
//     {
//         $this->password = $password;
//         return $this;
//     }

//     // Méthode requise par UserInterface pour effacer les données sensibles 
//     public function eraseCredentials(): void
//     {
//     }

//     // Retourne le prénom de l'utilisateur
//     public function getFirstName(): ?string
//     {
//         return $this->firstName;
//     }

//     // Définit le prénom de l'utilisateur
//     public function setFirstName(?string $firstName): self
//     {
//         $this->firstName = $firstName;
//         return $this;
//     }

//     // Retourne le nom de famille de l'utilisateur
//     public function getLastName(): ?string
//     {
//         return $this->lastName;
//     }

//     // Définit le nom de famille de l'utilisateur
//     public function setLastName(?string $lastName): self
//     {
//         $this->lastName = $lastName;
//         return $this;
//     }

//     // Retourne la date de création du compte utilisateur
//     public function getCreatedAt(): \DateTimeImmutable
//     {
//         return $this->createdAt;
//     }

//     // Retourne la dernière date de connexion de l'utilisateur
//     public function getLastLoginAt(): ?\DateTimeImmutable
//     {
//         return $this->lastLoginAt;
//     }

//     // Définit la dernière date de connexion de l'utilisateur
//     public function setLastLoginAt(\DateTimeImmutable $lastLoginAt): self
//     {
//         $this->lastLoginAt = $lastLoginAt;
//         return $this;
//     }

//     // Vérifie si le compte est actif
//     public function isActive(): bool
//     {
//         return $this->isActive;
//     }

//     // Définit si le compte est actif ou non
//     public function setIsActive(bool $isActive): self
//     {
//         $this->isActive = $isActive;
//         return $this;
//     }

//     // Retourne le nombre de tentatives de connexion échouées
//     public function getLoginAttempts(): int
//     {
//         return $this->loginAttempts;
//     }

//     // Incrémente le nombre de tentatives échouées et verrouille le compte si nécessaire
//     public function incrementLoginAttempts(): void
//     {
//         $this->loginAttempts++;
//         if ($this->loginAttempts >= 3) { // Si 3 tentatives échouées, verrouiller le compte
//             $this->isLocked = true;
//             $this->lockedAt = new \DateTimeImmutable('now');
//         }
//     }

//     // Réinitialise les tentatives de connexion et déverrouille le compte
//     public function resetLoginAttempts(): void
//     {
//         $this->loginAttempts = 0;
//         $this->isLocked = false;
//         $this->lockedAt = null;
//     }

//     // Vérifie si le compte est verrouillé et déverrouille automatiquement après 15 minutes
//     public function isLocked(): bool
//     {
//         if ($this->isLocked && $this->lockedAt) {
//             $now = new \DateTimeImmutable('now');
//             $elapsedTime = $now->getTimestamp() - $this->lockedAt->getTimestamp();

//             if ($elapsedTime > 900) { // Si 15 minutes sont écoulées
//                 $this->resetLoginAttempts();
//             }
//         }

//         return $this->isLocked;
//     }

//     // Définit si le compte est verrouillé
//     public function setLocked(bool $isLocked): self
//     {
//         $this->isLocked = $isLocked;
//         return $this;
//     }

//     // Retourne la date et l'heure où le compte a été verrouillé
//     public function getLockedAt(): ?\DateTimeImmutable
//     {
//         return $this->lockedAt;
//     }

//     // Retourne une représentation textuelle de l'utilisateur (email)
//     public function __toString(): string
//     {
//         return $this->email ?? '';
//     }
// }



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

    #[ORM\Column(name: "locked_at", type: "datetime_immutable", nullable: true)]
    private ?\DateTimeImmutable $lockedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        // Ajoute un rôle par défaut : ROLE_USER
        $roles[] = 'ROLE_USER';

        // Ajoute ROLE_EMPLOYE si nécessaire
        if (in_array('ROLE_EMPLOYE', $this->roles)) {
            $roles[] = 'ROLE_EMPLOYE';
        }

        return array_unique($roles); // Évite les doublons
    }

    public function setRoles(array $roles): self
    {
        // Enlève les doublons avant de définir les rôles
        $this->roles = array_unique($roles);
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        // Assure-toi que le mot de passe n'est pas vide
        if (empty($password)) {
            throw new \InvalidArgumentException("Le mot de passe ne peut pas être vide");
        }
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
        // Méthode nécessaire par UserInterface, mais rien à faire ici
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getLastLoginAt(): ?\DateTimeImmutable
    {
        return $this->lastLoginAt;
    }

    public function setLastLoginAt(\DateTimeImmutable $lastLoginAt): self
    {
        $this->lastLoginAt = $lastLoginAt;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getLoginAttempts(): int
    {
        return $this->loginAttempts;
    }

    public function incrementLoginAttempts(): void
    {
        $this->loginAttempts++;
        if ($this->loginAttempts >= 3) {
            $this->isLocked = true;
            $this->lockedAt = new \DateTimeImmutable('now');
        }
    }

    public function resetLoginAttempts(): void
    {
        $this->loginAttempts = 0;
        $this->isLocked = false;
        $this->lockedAt = null;
    }

    public function isLocked(): bool
    {
        if ($this->isLocked && $this->lockedAt) {
            $now = new \DateTimeImmutable('now');
            $elapsedTime = $now->getTimestamp() - $this->lockedAt->getTimestamp();

            if ($elapsedTime > 900) { // Si 15 minutes sont écoulées
                $this->resetLoginAttempts();
            }
        }

        return $this->isLocked;
    }

    public function setLocked(bool $isLocked): self
    {
        $this->isLocked = $isLocked;
        return $this;
    }

    public function getLockedAt(): ?\DateTimeImmutable
    {
        return $this->lockedAt;
    }

    public function __toString(): string
    {
        return $this->email ?? '';
    }
}



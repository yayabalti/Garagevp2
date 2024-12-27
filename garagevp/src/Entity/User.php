<?php  

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    // Vos constantes existantes...

    #[ORM\Id]
    #[ORM\Column(type: "string", length: 100)]
    private string $idUser;

    #[ORM\Column(type: "string", length: 50, unique: true)]
    private string $email;

    #[ORM\Column(type: "string", length: 150)]
    private string $motDePasse;

    #[ORM\Column(type: "string", length: 50)]
    private string $roleUtilisateur;

    #[ORM\Column(type: "datetimetz")]
    private \DateTimeInterface $dateEtHeuresDeConnexion;

    #[ORM\ManyToOne(targetEntity: Administrateur::class)]
    #[ORM\JoinColumn(name: "idAdministrateur", referencedColumnName: "idAdministrateur", nullable: true)]
    private ?Administrateur $administrateur = null;

    #[ORM\ManyToOne(targetEntity: Employe::class)]
    #[ORM\JoinColumn(name: "idEmploye", referencedColumnName: "idEmploye", nullable: true)]
    private ?Employe $employe = null;

    // Getters and Setters
    public function getIdUser(): string
    {
        return $this->idUser;
    }

    public function setIdUser(string $idUser): self
    {
        $this->idUser = $idUser;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getMotDePasse(): string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;
        return $this;
    }

    public function getRoleUtilisateur(): string
    {
        return $this->roleUtilisateur;
    }

    public function setRoleUtilisateur(string $roleUtilisateur): self
    {
        $this->roleUtilisateur = $roleUtilisateur;
        return $this;
    }

    public function getDateEtHeuresDeConnexion(): \DateTimeInterface
    {
        return $this->dateEtHeuresDeConnexion;
    }

    public function setDateEtHeuresDeConnexion(\DateTimeInterface $dateEtHeuresDeConnexion): self
    {
        $this->dateEtHeuresDeConnexion = $dateEtHeuresDeConnexion;
        return $this;
    }

    // Méthodes de l'interface UserInterface
    public function getRoles(): array
    {
        return [$this->roleUtilisateur];
    }

    public function getPassword(): string
    {
        return $this->motDePasse;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function eraseCredentials(): void
    {
        // $this->motDePasse = null;
    }
}







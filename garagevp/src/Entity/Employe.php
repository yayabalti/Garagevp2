<?php

namespace App\Entity;

use App\Repository\EmployeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeRepository::class)
 */
class Employe
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=250)
     */
    private string $idEmploye; // ID de l'employé

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $nom; // Nom de l'employé

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $prenom; // Prénom de l'employé

    /**
     * @ORM\Column(type="string", length=250, unique=true)
     */
    private string $email; // Email unique de l'employé

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $motDePasse; // Mot de passe de l'employé

    /**
     * @ORM\Column(type="datetimetz")
     */
    private \DateTimeInterface $dateConnexion; // Date de connexion

    /**
     * @ORM\ManyToOne(targetEntity="Avis")
     * @ORM\JoinColumn(nullable=false)
     */
    private Avis $avis; // Avis associé à l'employé

    // Getters et Setters

    public function getIdEmploye(): string
    {
        return $this->idEmploye;
    }

    public function setIdEmploye(string $idEmploye): self
    {
        $this->idEmploye = $idEmploye;
        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
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

    public function getDateConnexion(): \DateTimeInterface
    {
        return $this->dateConnexion;
    }

    public function setDateConnexion(\DateTimeInterface $dateConnexion): self
    {
        $this->dateConnexion = $dateConnexion;
        return $this;
    }

    public function getAvis(): Avis
    {
        return $this->avis;
    }

    public function setAvis(Avis $avis): self
    {
        $this->avis = $avis;
        return $this;
    }
}



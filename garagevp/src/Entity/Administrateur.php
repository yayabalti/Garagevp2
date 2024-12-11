<?php

namespace App\Entity;

use App\Repository\AdministrateurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdministrateurRepository::class)
 */
class Administrateur
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=250)
     */
    private string $idAdministrateur; // ID de l'administrateur

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $nom; // Nom de l'administrateur

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $prenom; // Prénom de l'administrateur

    /**
     * @ORM\Column(type="string", length=50, unique=true)
     */
    private string $email; // Email unique de l'administrateur

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $motDePasse; // Mot de passe de l'administrateur

    /**
     * @ORM\Column(type="datetimetz")
     */
    private \DateTimeInterface $dateConnexion; // Date de connexion

    /**
     * @ORM\OneToOne(targetEntity="ServiceEntretien")
     * @ORM\JoinColumn(nullable=false)
     */
    private ServiceEntretien $serviceEntretien; // Service d'entretien

    /**
     * @ORM\OneToOne(targetEntity="ServiceCarrosserie")
     * @ORM\JoinColumn(nullable=false)
     */
    private ServiceCarrosserie $serviceCarrosserie; // Service de carrosserie

    /**
     * @ORM\OneToOne(targetEntity="ServiceMecanique")
     * @ORM\JoinColumn(nullable=false)
     */
    private ServiceMecanique $serviceMecanique; // Service mécanique

    /**
     * @ORM\OneToOne(targetEntity="HoraireGarage")
     * @ORM\JoinColumn(nullable=false)
     */
    private HoraireGarage $horaireGarage; // Horaire du garage

    /**
     * @ORM\OneToOne(targetEntity="InfoGarage")
     * @ORM\JoinColumn(nullable=false)
     */
    private InfoGarage $infoGarage; // Infos du garage

    /**
     * @ORM\ManyToOne(targetEntity="Employe")
     */
    private Employe $employe; // Employé associé

    // Getters et Setters

    public function getIdAdministrateur(): string
    {
        return $this->idAdministrateur;
    }

    public function setIdAdministrateur(string $idAdministrateur): self
    {
        $this->idAdministrateur = $idAdministrateur;
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

    public function getServiceEntretien(): ServiceEntretien
    {
        return $this->serviceEntretien;
    }

    public function setServiceEntretien(ServiceEntretien $serviceEntretien): self
    {
        $this->serviceEntretien = $serviceEntretien;
        return $this;
    }

    public function getServiceCarrosserie(): ServiceCarrosserie
    {
        return $this->serviceCarrosserie;
    }

    public function setServiceCarrosserie(ServiceCarrosserie $serviceCarrosserie): self
    {
        $this->serviceCarrosserie = $serviceCarrosserie;
        return $this;
    }

    public function getServiceMecanique(): ServiceMecanique
    {
        return $this->serviceMecanique;
    }

    public function setServiceMecanique(ServiceMecanique $serviceMecanique): self
    {
        $this->serviceMecanique = $serviceMecanique;
        return $this;
    }

    public function getHoraireGarage(): HoraireGarage
    {
        return $this->horaireGarage;
    }

    public function setHoraireGarage(HoraireGarage $horaireGarage): self
    {
        $this->horaireGarage = $horaireGarage;
        return $this;
    }

    public function getInfoGarage(): InfoGarage
    {
        return $this->infoGarage;
    }

    public function setInfoGarage(InfoGarage $infoGarage): self
    {
        $this->infoGarage = $infoGarage;
        return $this;
    }

    public function getEmploye(): Employe
    {
        return $this->employe;
    }

    public function setEmploye(Employe $employe): self
    {
        $this->employe = $employe;
        return $this;
    }
}





<?php

namespace App\Entity;

use App\Repository\ServiceventevoitureoccasionRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceventevoitureoccasionRepository::class)
 */
class ServiceVenteVoitureOccasion
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=200)
     */
    private string $idVoiture; // ID de la voiture

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $marque; // Marque de la voiture

    /**
     * @ORM\Column(type="string", length=50)
     */
    private string $model; // Modèle de la voiture

    /**
     * @ORM\Column(type="date")
     */
    private \DateTimeInterface $anneeMiseEnCirculation; // Année de mise en circulation

    /**
     * @ORM\Column(type="decimal", precision=25, scale=2)
     */
    private float $prix; // Prix de la voiture

    /**
     * @ORM\Column(type="integer")
     */
    private int $kilometrage; // Kilométrage de la voiture

    /**
     * @ORM\Column(type="text")
     */
    private string $description; // Description de la voiture

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $imagePrincipale; // Image principale de la voiture

    /**
     * @ORM\Column(type="text")
     */
    private string $galerieImages; // Galerie d'images

    /**
     * @ORM\Column(type="text")
     */
    private string $caracteristiques; // Caractéristiques de la voiture

    /**
     * @ORM\Column(type="text")
     */
    private string $equipements; // Équipements de la voiture

    /**
     * @ORM\ManyToOne(targetEntity="Visiteur")
     * @ORM\JoinColumn(nullable=false)
     */
    private Visiteur $visiteur; // Lien vers l'entité Visiteur

    /**
     * @ORM\ManyToOne(targetEntity="Employe")
     * @ORM\JoinColumn(nullable=false)
     */
    private Employe $employe; // Lien vers l'entité Employé

    // Getters et setters

    public function getIdVoiture(): string
    {
        return $this->idVoiture;
    }

    public function setIdVoiture(string $idVoiture): self
    {
        $this->idVoiture = $idVoiture;
        return $this;
    }

    public function getMarque(): string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;
        return $this;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function getAnneeMiseEnCirculation(): \DateTimeInterface
    {
        return $this->anneeMiseEnCirculation;
    }

    public function setAnneeMiseEnCirculation(\DateTimeInterface $anneeMiseEnCirculation): self
    {
        $this->anneeMiseEnCirculation = $anneeMiseEnCirculation;
        return $this;
    }

    public function getPrix(): float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    public function getKilometrage(): int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getImagePrincipale(): string
    {
        return $this->imagePrincipale;
    }

    public function setImagePrincipale(string $imagePrincipale): self
    {
        $this->imagePrincipale = $imagePrincipale;
        return $this;
    }

    public function getGalerieImages(): string
    {
        return $this->galerieImages;
    }

    public function setGalerieImages(string $galerieImages): self
    {
        $this->galerieImages = $galerieImages;
        return $this;
    }

    public function getCaracteristiques(): string
    {
        return $this->caracteristiques;
    }

    public function setCaracteristiques(string $caracteristiques): self
    {
        $this->caracteristiques = $caracteristiques;
        return $this;
    }

    public function getEquipements(): string
    {
        return $this->equipements;
    }

    public function setEquipements(string $equipements): self
    {
        $this->equipements = $equipements;
        return $this;
    }

    public function getVisiteur(): Visiteur
    {
        return $this->visiteur;
    }

    public function setVisiteur(Visiteur $visiteur): self
    {
        $this->visiteur = $visiteur;
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




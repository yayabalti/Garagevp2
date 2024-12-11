<?php

namespace App\Entity;

use App\Repository\ServiceEntretienRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServiceEntretienRepository::class)
 */
class ServiceEntretien
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=100)
     */
    private string $idServiceEntretien; // ID unique du service d'entretien

    /**
     * @ORM\Column(type="string", length=200)
     */
    private string $typeService; // Type de service

    /**
     * @ORM\Column(type="string", length=350)
     */
    private string $descriptionTravaux; // Description des travaux

    /**
     * @ORM\Column(type="time")
     */
    private \DateTimeInterface $dureeEstimee; // Durée estimée du service

    /**
     * @ORM\Column(type="decimal", precision=5, scale=0)
     */
    private float $tarif; // Tarif du service

    /**
     * @ORM\Column(type="string", length=330)
     */
    private string $equipementUtilisee; // Équipement utilisé pour le service

    /**
     * @ORM\ManyToOne(targetEntity="Visiteur")
     */
    private ?Visiteur $visiteur = null; // Lien vers le visiteur

    // Getters et Setters

    public function getIdServiceEntretien(): string
    {
        return $this->idServiceEntretien;
    }

    public function setIdServiceEntretien(string $idServiceEntretien): self
    {
        $this->idServiceEntretien = $idServiceEntretien;
        return $this;
    }

    public function getTypeService(): string
    {
        return $this->typeService;
    }

    public function setTypeService(string $typeService): self
    {
        $this->typeService = $typeService;
        return $this;
    }

    public function getDescriptionTravaux(): string
    {
        return $this->descriptionTravaux;
    }

    public function setDescriptionTravaux(string $descriptionTravaux): self
    {
        $this->descriptionTravaux = $descriptionTravaux;
        return $this;
    }

    public function getDureeEstimee(): \DateTimeInterface
    {
        return $this->dureeEstimee;
    }

    public function setDureeEstimee(\DateTimeInterface $dureeEstimee): self
    {
        $this->dureeEstimee = $dureeEstimee;
        return $this;
    }

    public function getTarif(): float
    {
        return $this->tarif;
    }

    public function setTarif(float $tarif): self
    {
        $this->tarif = $tarif;
        return $this;
    }

    public function getEquipementUtilisee(): string
    {
        return $this->equipementUtilisee;
    }

    public function setEquipementUtilisee(string $equipementUtilisee): self
    {
        $this->equipementUtilisee = $equipementUtilisee;
        return $this;
    }

    public function getVisiteur(): ?Visiteur
    {
        return $this->visiteur;
    }

    public function setVisiteur(?Visiteur $visiteur): self
    {
        $this->visiteur = $visiteur;
        return $this;
    }
}



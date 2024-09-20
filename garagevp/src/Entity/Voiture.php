<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoitureRepository")
 */
class Voiture
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=200)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $model;

    /**
     * @ORM\Column(type="date")
     */
    private $anneeMiseEnCirculation;

    /**
     * @ORM\Column(type="decimal", scale=2)
     */
    private $prix;

    /**
     * @ORM\Column(type="integer")
     */
    private $kilometrage;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $imagePrincipale;

    /**
     * @ORM\Column(type="text")
     */
    private $galerieImages;

    /**
     * @ORM\Column(type="text")
     */
    private $caracteristiques;

    /**
     * @ORM\Column(type="text")
     */
    private $equipements;

    // Getters and Setters

    public function getId(): ?string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;
        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function getAnneeMiseEnCirculation(): ?\DateTimeInterface
    {
        return $this->anneeMiseEnCirculation;
    }

    public function setAnneeMiseEnCirculation(\DateTimeInterface $anneeMiseEnCirculation): self
    {
        $this->anneeMiseEnCirculation = $anneeMiseEnCirculation;
        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;
        return $this;
    }

    public function getKilometrage(): ?int
    {
        return $this->kilometrage;
    }

    public function setKilometrage(int $kilometrage): self
    {
        $this->kilometrage = $kilometrage;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function getImagePrincipale(): ?string
    {
        return $this->imagePrincipale;
    }

    public function setImagePrincipale(string $imagePrincipale): self
    {
        $this->imagePrincipale = $imagePrincipale;
        return $this;
    }

    public function getGalerieImages(): ?string
    {
        return $this->galerieImages;
    }

    public function setGalerieImages(string $galerieImages): self
    {
        $this->galerieImages = $galerieImages;
        return $this;
    }

    public function getCaracteristiques(): ?string
    {
        return $this->caracteristiques;
    }

    public function setCaracteristiques(string $caracteristiques): self
    {
        $this->caracteristiques = $caracteristiques;
        return $this;
    }

    public function getEquipements(): ?string
    {
        return $this->equipements;
    }

    public function setEquipements(string $equipements): self
    {
        $this->equipements = $equipements;
        return $this;
    }
}


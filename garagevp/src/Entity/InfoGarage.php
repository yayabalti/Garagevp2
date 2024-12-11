<?php

namespace App\Entity;

use App\Repository\InfogarageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InfogarageRepository::class)
 */
class InfoGarage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=100)
     */
    private string $idInfoGarage; // ID unique de l'info garage

    /**
     * @ORM\Column(type="string", length=250)
     */
    private string $adresse; // Adresse de l'info garage

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $ville; // Ville de l'info garage

    /**
     * @ORM\Column(type="string", length=20)
     */
    private string $codePostal; // Code postal de l'info garage

    /**
     * @ORM\Column(type="string", length=100)
     */
    private string $pays; // Pays de l'info garage

    /**
     * @ORM\Column(type="string", length=20)
     */
    private string $numeroTelephone; // Numéro de téléphone de l'info garage

    /**
     * @ORM\Column(type="string", length=100, unique=true)
     */
    private string $email; // Email de l'info garage

    /**
     * @ORM\ManyToOne(targetEntity="Visiteur")
     */
    private ?Visiteur $visiteur = null; // Lien vers le visiteur

    // Getters et Setters

    public function getIdInfoGarage(): string
    {
        return $this->idInfoGarage;
    }

    public function setIdInfoGarage(string $idInfoGarage): self
    {
        $this->idInfoGarage = $idInfoGarage;
        return $this;
    }

    public function getAdresse(): string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getVille(): string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;
        return $this;
    }

    public function getCodePostal(): string
    {
        return $this->codePostal;
    }

    public function setCodePostal(string $codePostal): self
    {
        $this->codePostal = $codePostal;
        return $this;
    }

    public function getPays(): string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;
        return $this;
    }

    public function getNumeroTelephone(): string
    {
        return $this->numeroTelephone;
    }

    public function setNumeroTelephone(string $numeroTelephone): self
    {
        $this->numeroTelephone = $numeroTelephone;
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



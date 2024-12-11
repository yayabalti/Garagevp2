<?php

namespace App\Entity;

use App\Repository\VisiteurRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VisiteurRepository::class)
 */
#[ORM\Entity(repositoryClass: VisiteurRepository::class)]
class Visiteur
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 250)]
    private string $idVisiteur; // ID du visiteur

    #[ORM\Column(type: "string", length: 250)]
    private string $nom; // Nom du visiteur

    #[ORM\Column(type: "string", length: 250)]
    private string $prenom; // Prénom du visiteur

    #[ORM\Column(type: "datetimetz")]
    private \DateTimeInterface $dateConnexion; // Date de connexion du visiteur

    #[ORM\ManyToOne(targetEntity: Avis::class)]
    #[ORM\JoinColumn(name: "ID_Avis", referencedColumnName: "idAvis", nullable: false)]
    private Avis $avis; // Lien vers l'avis donné par le visiteur

    // Getters et Setters

    public function getIdVisiteur(): string
    {
        return $this->idVisiteur;
    }

    public function setIdVisiteur(string $idVisiteur): self
    {
        $this->idVisiteur = $idVisiteur;
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



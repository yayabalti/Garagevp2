<?php

namespace App\Entity;

use App\Repository\AvisRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvisRepository::class)]
class Avis
{
    #[ORM\Id]
    #[ORM\Column(type: "string", length: 200)]
    private string $idAvis; // ID de l'avis

    #[ORM\Column(type: "string", length: 50)]
    private string $nom; // Nom de l'utilisateur ayant donné l'avis

    #[ORM\Column(type: "string", length: 50)]
    private string $prenom; // Prénom de l'utilisateur ayant donné l'avis

    #[ORM\Column(type: "text")]
    private string $commentaire; // Commentaire de l'utilisateur

    #[ORM\Column(type: "decimal", precision: 1, scale: 0)]
    private string $note; // Note de l'avis (de 0 à 1)

    #[ORM\Column(type: "datetimetz")]
    private \DateTimeInterface $dateAvis; // Date à laquelle l'avis a été donné

    // Getters et Setters

    public function getIdAvis(): string
    {
        return $this->idAvis;
    }

    public function setIdAvis(string $idAvis): self
    {
        $this->idAvis = $idAvis;
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

    public function getCommentaire(): string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    public function getNote(): string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;
        return $this;
    }

    public function getDateAvis(): \DateTimeInterface
    {
        return $this->dateAvis;
    }

    public function setDateAvis(\DateTimeInterface $dateAvis): self
    {
        $this->dateAvis = $dateAvis;
        return $this;
    }
}



<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Avis
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le prénom est obligatoire.")]
    private ?string $prenom = null;

    #[ORM\Column(type: "text")]
    #[Assert\NotBlank(message: "Le commentaire ne peut pas être vide.")]
    #[Assert\Length(max: 1000, maxMessage: "Le commentaire ne peut pas dépasser 1000 caractères.")]
    private ?string $commentaire = null;

    #[ORM\Column(type: "integer")]
    #[Assert\Range(min: 1, max: 5, notInRangeMessage: "La note doit être entre 1 et 5.")]
    private ?int $note = null;

    #[ORM\Column(type: "boolean")]
    private bool $approuve = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;
        return $this;
    }

    public function getNote(): ?int
    {
        return $this->note;
    }

    public function setNote(int $note): self
    {
        $this->note = $note;
        return $this;
    }

    public function isApprouve(): bool
    {
        return $this->approuve;
    }

    public function setApprouve(bool $approuve): self
    {
        $this->approuve = $approuve;
        return $this;
    }

    public function __toString(): string
    {
        return sprintf("%s %s (%d)", $this->prenom, $this->nom, $this->note);
    }
}



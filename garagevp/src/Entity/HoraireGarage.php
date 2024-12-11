<?php

namespace App\Entity;

use App\Repository\HorairegarageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HorairegarageRepository::class)
 */
class HoraireGarage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=200)
     */
    private string $idHoraireGarage; // ID du horaire de garage

    /**
     * @ORM\Column(type="string", length=15)
     */
    private string $jourDeSemaine; // Jour de la semaine

    /**
     * @ORM\Column(type="time")
     */
    private \DateTimeInterface $heureOuverture; // Heure d'ouverture

    /**
     * @ORM\Column(type="time")
     */
    private \DateTimeInterface $heureFermeture; // Heure de fermeture

    /**
     * @ORM\Column(type="boolean")
     */
    private bool $fermetureGarage; // Indique si le garage est fermé

    /**
     * @ORM\ManyToOne(targetEntity="Visiteur")
     * @ORM\JoinColumn(name="ID_Visiteur", referencedColumnName="idVisiteur", nullable=true)
     */
    private ?Visiteur $visiteur = null; // Lien vers le visiteur

    // Getters et Setters

    public function getIdHoraireGarage(): string
    {
        return $this->idHoraireGarage;
    }

    public function setIdHoraireGarage(string $idHoraireGarage): self
    {
        $this->idHoraireGarage = $idHoraireGarage;
        return $this;
    }

    public function getJourDeSemaine(): string
    {
        return $this->jourDeSemaine;
    }

    public function setJourDeSemaine(string $jourDeSemaine): self
    {
        $this->jourDeSemaine = $jourDeSemaine;
        return $this;
    }

    public function getHeureOuverture(): \DateTimeInterface
    {
        return $this->heureOuverture;
    }

    public function setHeureOuverture(\DateTimeInterface $heureOuverture): self
    {
        $this->heureOuverture = $heureOuverture;
        return $this;
    }

    public function getHeureFermeture(): \DateTimeInterface
    {
        return $this->heureFermeture;
    }

    public function setHeureFermeture(\DateTimeInterface $heureFermeture): self
    {
        $this->heureFermeture = $heureFermeture;
        return $this;
    }

    public function isFermetureGarage(): bool
    {
        return $this->fermetureGarage;
    }

    public function setFermetureGarage(bool $fermetureGarage): self
    {
        $this->fermetureGarage = $fermetureGarage;
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



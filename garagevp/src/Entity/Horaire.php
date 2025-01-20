<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Horaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 20)]
    private ?string $jour = null;

    #[ORM\Column(length: 20)]
    private ?string $heureOuvertureMatin = null;

    #[ORM\Column(length: 20)]
    private ?string $heureFermetureMatin = null;

    #[ORM\Column(length: 20)]
    private ?string $heureOuvertureAprem = null;

    #[ORM\Column(length: 20)]
    private ?string $heureFermetureAprem = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJour(): ?string
    {
        return $this->jour;
    }

    public function setJour(string $jour): self
    {
        $this->jour = $jour;
        return $this;
    }

    public function getHeureOuvertureMatin(): ?string
    {
        return $this->heureOuvertureMatin;
    }

    public function setHeureOuvertureMatin(string $heureOuvertureMatin): self
    {
        $this->heureOuvertureMatin = $heureOuvertureMatin;
        return $this;
    }

    public function getHeureFermetureMatin(): ?string
    {
        return $this->heureFermetureMatin;
    }

    public function setHeureFermetureMatin(string $heureFermetureMatin): self
    {
        $this->heureFermetureMatin = $heureFermetureMatin;
        return $this;
    }

    public function getHeureOuvertureAprem(): ?string
    {
        return $this->heureOuvertureAprem;
    }

    public function setHeureOuvertureAprem(string $heureOuvertureAprem): self
    {
        $this->heureOuvertureAprem = $heureOuvertureAprem;
        return $this;
    }

    public function getHeureFermetureAprem(): ?string
    {
        return $this->heureFermetureAprem;
    }

    public function setHeureFermetureAprem(string $heureFermetureAprem): self
    {
        $this->heureFermetureAprem = $heureFermetureAprem;
        return $this;
    }

    public function __toString(): string
    {
        return $this->jour ?? '';
    }
}
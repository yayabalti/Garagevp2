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

    
}
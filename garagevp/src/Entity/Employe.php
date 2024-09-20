<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Employe
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 250)]
    private $idEmploye;

    #[ORM\Column(type: 'string', length: 250)]
    #[Assert\NotBlank]
    private $nom;

    #[ORM\Column(type: 'string', length: 250)]
    #[Assert\NotBlank]
    private $prenom;

    #[ORM\Column(type: 'string', length: 250, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private $email;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private $motDePasse;

    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank]
    private $dateNaissance;

    #[ORM\Column(type: 'string', length: 250)]
    #[Assert\NotBlank]
    private $adresse;

    #[ORM\Column(type: 'string', length: 450)]
    #[Assert\NotBlank]
    private $diplomeExperience;

    #[ORM\Column(type: 'datetime')]
    private $dateConnexion;

    // Getters et setters...
}

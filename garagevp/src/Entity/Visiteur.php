<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Visiteur
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 250)]
    private $idVisiteur;

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

    #[ORM\Column(type: 'string', length: 100)]
    #[Assert\NotBlank]
    private $telephone;

    #[ORM\Column(type: 'text')]
    #[Assert\NotBlank]
    private $message;

    #[ORM\Column(type: 'datetime')]
    private $dateConnexion;

    // Getters et setters...
}

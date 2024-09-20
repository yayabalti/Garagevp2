<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity]
class Administrateur
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 250)]
    private $idAdministrateur;

    #[ORM\Column(type: 'string', length: 250)]
    #[Assert\NotBlank]
    private $nom;

    #[ORM\Column(type: 'string', length: 250)]
    #[Assert\NotBlank]
    private $prenom;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Email]
    private $email;

    #[ORM\Column(type: 'datetime')]
    private $dateConnexion;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private $motDePasse;

    #[ORM\ManyToOne(targetEntity: Employe::class)]
    #[ORM\JoinColumn(name: 'id_employe', referencedColumnName: 'id_employe')]
    private $employe;

    #[ORM\ManyToOne(targetEntity: Employe::class)]
    #[ORM\JoinColumn(name: 'id_employe_1', referencedColumnName: 'id_employe')]
    private $employe1;

    // Getters et setters...
}

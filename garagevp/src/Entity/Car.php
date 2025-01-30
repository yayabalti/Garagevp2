<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Repository\CarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;



#[ORM\Entity(repositoryClass: CarRepository::class)]
#[ORM\Table(name: "cars")]
class Car
{
    
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private ?int $id = null;
    
    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "Le modèle de la voiture est obligatoire")]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: "Le modèle doit contenir au moins {{ limit }} caractères",
        maxMessage: "Le modèle ne peut pas dépasser {{ limit }} caractères"
    )]
    private string $model;
    
    #[ORM\Column(type: "string", length: 255)]
    #[Assert\NotBlank(message: "La marque est obligatoire")]
    #[Assert\Choice(
        choices: ['Peugeot', 'Renault', 'Audi', 'BMW', 'Mercedes','Opel','Dacia','Volkswagen','Seat','Citroën'],
        message: "Veuillez choisir une marque valide"
    )]
    private string $brand;
    
    #[ORM\Column(type: "integer")]
    #[Assert\NotBlank(message: "L'année est obligatoire")]
    #[Assert\Range(
        min: 1900,
        max: 2025,
        notInRangeMessage: "L'année doit être comprise entre {{ min }} et {{ max }}"
    )]
    private int $year;
    
    #[ORM\Column(type: "string", length: 10)]
    #[Assert\Choice(
        choices: ['diesel', 'essence'],
        message: "Type de carburant invalide"
    )]
    private string $engineType;
    
    #[ORM\Column(type: "integer")]
    #[Assert\NotBlank(message: "Le kilométrage est obligatoire")]
    #[Assert\Positive(message: "Le kilométrage doit être un nombre positif")]
    #[Assert\Range(
        min: 0,
        max: 200000,
        notInRangeMessage: "Le kilométrage doit être entre {{ min }} et {{ max }}."
    )]
    private int $mileage;
    
    #[ORM\Column(type: "decimal", precision: 10, scale: 2)]
    #[Assert\NotBlank(message: "Le prix est obligatoire")]
    #[Assert\Positive(message: "Le prix doit être positif")]
    #[Assert\Range(
        min: 0,
        max: 1000000,
        notInRangeMessage: "Le prix doit être entre {{ min }} et {{ max }} euros."
    )]
    private ?float  $price = null;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;
    
    #[Assert\Image(
        maxSize: '5M',
        maxSizeMessage: 'Le fichier est trop volumineux ({{ size }} {{ suffix }}). Maximum : {{ limit }} {{ suffix }}.',
        mimeTypes: ['image/jpeg', 'image/png', 'image/gif'],
        mimeTypesMessage: 'Format invalide ({{ type }}). Formats acceptés : {{ types }}'
    )]
    private $imageFile = null;
    
    #[ORM\Column(type: "text", nullable: true)]
    #[Assert\Length(
        max: 1000,
        maxMessage: "La description ne peut pas dépasser {{ limit }} caractères"
    )]
    private ?string $description = null;
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModel(): string
    {
        return $this->model;
    }

    public function setModel(string $model): self
    {
        $this->model = $model;
        return $this;
    }

    public function getBrand(): string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    public function getYear(): int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;
        return $this;
    }

    public function getEngineType(): string
    {
        return $this->engineType;
    }

    public function setEngineType(string $engineType): self
    {
        $this->engineType = $engineType;
        return $this;
    }

    public function getMileage(): int
    {
        return $this->mileage;
    }

    public function setMileage(int $mileage): self
    {
        $this->mileage = $mileage;
        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getImageFile(): ?UploadedFile
    {
        return $this->imageFile;
    }

    public function setImageFile(?UploadedFile $imageFile): self
    {
        $this->imageFile = $imageFile;
        return $this;
    }


    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;
        return $this;
    }
}





<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Liste des voitures avec leur modèle, marque et image associée
        $carsData = [
            ['model' => '208', 'brand' => 'Peugeot', 'image' => 'uploads/peugeot_208.jpg'],
            ['model' => 'Clio', 'brand' => 'Renault', 'image' => 'uploads/renault_clio.jpg'],
            ['model' => 'C3', 'brand' => 'Citroën', 'image' => 'uploads/citroen_c3.jpg'],
            ['model' => 'Golf', 'brand' => 'Volkswagen', 'image' => 'uploads/vw_golf.jpg'],
            ['model' => 'Serie 3', 'brand' => 'BMW', 'image' => 'uploads/bmw_serie3.jpg'],
            ['model' => 'A3', 'brand' => 'Audi', 'image' => 'uploads/audi_a3.jpg'],
            ['model' => 'Megane', 'brand' => 'Renault', 'image' => 'uploads/renault_megane.jpg'],
            ['model' => '3008', 'brand' => 'Peugeot', 'image' => 'uploads/peugeot_3008.jpg'],
            ['model' => 'Tiguan', 'brand' => 'Volkswagen', 'image' => 'uploads/vw_tiguan.jpg'],
            ['model' => 'Q5', 'brand' => 'Audi', 'image' => 'uploads/audi_q5.jpg'],
        ];

        // Types de carburant disponibles
        $engineTypes = ['diesel', 'essence'];

        // Génération des données pour chaque voiture
        foreach ($carsData as $data) {
            $car = new Car();
            $car->setModel($data['model'])
                ->setbrand($data['brand'])
                ->setYear(rand(1900, 2025)) // Génère une année entre 2005 et 2023
                ->setEngineType($engineTypes[array_rand($engineTypes)]) // Associe un type de carburant aléatoire
                ->setMileage(rand(5000, 300000)) // Génère un kilométrage entre 5 000 et 200 000
                ->setPrice(rand(5000, 50000)) // Génère un prix entre 5 000 € et 50 000 €
                ->setDescription('Une superbe ' . $data['brand'] . ' ' . $data['model'] . ' en excellent état.')
                ->setImage($data['image']); // Associe l'image au modèle

            // Persiste l'entité Car dans la base de données
            $manager->persist($car);
        }

        // Enregistre toutes les voitures dans la base de données
        $manager->flush();
    }
}



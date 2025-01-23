<?php

namespace App\DataFixtures;

use App\Entity\Car;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class CarFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Création d'une instance de Faker
        $faker = Factory::create();

        // Liste de marques et types de carburant
        $brands = ['Peugeot', 'Renault', 'Citroën', 'Volkswagen', 'BMW', 'Audi'];
        $engineTypes = ['diesel', 'essence'];

        // Génération de 10 voitures avec des données aléatoires
        for ($i = 0; $i < 10; $i++) {
            $car = new Car();
            $car->setModel($faker->word) // Génère un modèle de voiture aléatoire
                ->setBrand($brands[array_rand($brands)]) // Choisit une marque de voiture aléatoire
                ->setYear($faker->year) // Génère une année aléatoire
                ->setEngineType($engineTypes[array_rand($engineTypes)]) // Choisit un type de carburant (diesel ou essence)
                ->setMileage($faker->numberBetween(10000, 200000)) // Génère un kilométrage entre 10 000 et 200 000
                ->setPrice($faker->randomFloat(2, 2000, 50000)) // Génère un prix entre 5 000 € et 50 000 €
                ->setDescription($faker->sentence) // Génère une description courte
                ->setImage($faker->imageUrl(400, 300)); // Génère une URL d'image aléatoire

            // Persiste l'entité Car dans la base de données
            $manager->persist($car);
        }

        // Enregistre les voitures dans la base de données
        $manager->flush();
    }
}



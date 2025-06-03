<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\DBAL\Connection;

class UserFixtures extends Fixture
{
    public function __construct(
        private UserPasswordHasherInterface $passwordHasher,
        private Connection $connection
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // Nettoie la table users avant d'insérer les données
        $this->connection->executeStatement('TRUNCATE TABLE users RESTART IDENTITY CASCADE');

        // Création de l'admin principal
        $admin = new User();
        $admin->setEmail('vincent-parrot@gmail.com')
              ->setRoles(['ROLE_ADMIN'])
              ->setFirstName('Vincent')
              ->setLastName('Parrot')
              ->setPassword(
                  $this->passwordHasher->hashPassword($admin, 'Armanie_77')
              );

        $manager->persist($admin);
        $manager->flush();
    }
}
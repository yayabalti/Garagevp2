<?php
namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    public function load(ObjectManager $manager): void
    {
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
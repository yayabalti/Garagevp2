<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class CarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Car::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            // ID de la voiture
            IdField::new('id')->hideOnForm(),

            // Modèle de la voiture
            TextField::new('model'),

            // Marque de la voiture
            TextField::new('brand'),

            // Année de mise en circulation
            IntegerField::new('year'),

            // Type de carburant (Diesel ou Essence)
            ChoiceField::new('engineType')
                ->setChoices([
                    'Diesel' => 'diesel',
                    'Essence' => 'essence',
                ]),

            // Kilométrage
            IntegerField::new('mileage'),

            // Prix de la voiture
            MoneyField::new('price')
                ->setCurrency('EUR'),

            // Image de la voiture
            ImageField::new('image')
                ->setBasePath('/uploads/images/cars')
                ->setUploadDir('public/uploads/images/cars')
                ->setRequired(false),

            // Description de la voiture
            TextareaField::new('description'),

            // Date de création ou de modification (optionnel)
            DateTimeField::new('createdAt')->onlyOnIndex(),
        ];
    }
}

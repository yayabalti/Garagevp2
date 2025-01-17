<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class ServiceCarrosserieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            ChoiceField::new('categorie')->setChoices([
                'Ponçage et peinture' => 'poncage_peinture',
                'Réparation carrosserie' => 'reparation_carrosserie',
                'Remplacement d\'éléments' => 'remplacement_elements'
            ]),
            TextEditorField::new('description'),
        ];
    }
    public function createEntity(string $entityFqcn)
    {
        $service = new Service();
        $service->setCategorie('carrosserie');
        return $service;
    }
}
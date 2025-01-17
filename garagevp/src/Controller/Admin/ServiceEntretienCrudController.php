<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class ServiceEntretienCrudController extends AbstractCrudController
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
                'Vidange et filtres' => 'vidange_filtres',
                'Pneus et freins' => 'pneus_freins',
                'Diagnostic électrique' => 'diagnostic_electrique',
                'Batterie' => 'batterie'
            ]),
            TextEditorField::new('description'),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $service = new Service();
        $service->setCategorie('entretien');
        return $service;
    }
}
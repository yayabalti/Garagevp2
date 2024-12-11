<?php

namespace App\Controller\Admin;

use App\Entity\HoraireGarage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class HoraireGarageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HoraireGarage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('idHoraireGarage')->hideOnForm(),
            TextField::new('jourDeSemaine'),
            TimeField::new('heureOuverture'),
            TimeField::new('heureFermeture'),
            BooleanField::new('fermetureGarage'),
            AssociationField::new('visiteur')
        ];
    }
}
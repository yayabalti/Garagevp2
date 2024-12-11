<?php

namespace App\Controller\Admin;

use App\Entity\InfoGarage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class InfoGarageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InfoGarage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('idInfoGarage')->hideOnForm(),
            TextField::new('adresse'),
            TextField::new('ville'),
            TextField::new('codePostal'),
            TextField::new('pays'),
            TextField::new('numeroTelephone'),
            EmailField::new('email'),
            AssociationField::new('visiteur')
        ];
    }
}
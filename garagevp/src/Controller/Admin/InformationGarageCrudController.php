<?php

namespace App\Controller\Admin;

use App\Entity\InformationGarage;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class InformationGarageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InformationGarage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('adresse'),
            EmailField::new('email'),
            TelephoneField::new('telephone'),
            TextareaField::new('horaires'),
        ];
    }
}
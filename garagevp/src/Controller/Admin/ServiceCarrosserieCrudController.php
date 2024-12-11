<?php

namespace App\Controller\Admin;

use App\Entity\ServiceCarrosserie;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ServiceCarrosserieCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ServiceCarrosserie::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('idServicesCarrosserie')->hideOnForm(),
            TextField::new('typeService'),
            TextEditorField::new('descriptionTravaux'),
            TimeField::new('dureeEstimee'),
            MoneyField::new('tarif')->setCurrency('EUR'),
            TextField::new('equipementUtilisee'),
            AssociationField::new('visiteur')
        ];
    }
}
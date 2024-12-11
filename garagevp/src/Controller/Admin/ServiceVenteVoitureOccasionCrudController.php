<?php

namespace App\Controller\Admin;

use App\Entity\ServiceVenteVoitureOccasion;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class ServiceVenteVoitureOccasionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ServiceVenteVoitureOccasion::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('idVoiture')->hideOnForm(),
            TextField::new('marque'),
            TextField::new('model'),
            DateField::new('anneeMiseEnCirculation'),
            MoneyField::new('prix')->setCurrency('EUR'),
            IntegerField::new('kilometrage'),
            TextEditorField::new('description'),
            ImageField::new('imagePrincipale')
                ->setBasePath('uploads/voitures')
                ->setUploadDir('public/uploads/voitures'),
            TextEditorField::new('galerieImages'),
            TextEditorField::new('caracteristiques'),
            TextEditorField::new('equipements'),
            AssociationField::new('visiteur'),
            AssociationField::new('employe')
        ];
    }
}
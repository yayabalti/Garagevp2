<?php

namespace App\Controller\Admin;

use App\Entity\Avis;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;

class AvisCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Avis::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('idAvis')->hideOnForm(),
            TextField::new('nom'),
            TextField::new('prenom'),
            TextEditorField::new('commentaire'),
            NumberField::new('note')
                ->setHelp('Note de 0 à 5'),
            DateTimeField::new('dateAvis')
                ->setFormat('dd/MM/yyyy HH:mm')
        ];
    }
}
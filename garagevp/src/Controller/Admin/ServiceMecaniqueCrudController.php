<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class ServiceMecaniqueCrudController extends AbstractCrudController
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
                'Moteur' => 'moteur',
                'Freinage' => 'freinage',
                'Échappement' => 'echappement',
                'Suspension' => 'suspension',
                'Pneumatique' => 'pneumatique'
            ]),
            TextEditorField::new('description'),
        ];
    }
}
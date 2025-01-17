<?php
namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class ServiceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'), // Nom du service
            ChoiceField::new('type')
                ->setChoices([
                    'Mécanique' => 'mecanique',
                    'Entretien' => 'entretien',
                    'Carrosserie' => 'carrosserie',
                ])
                ->setRequired(true),
            ChoiceField::new('sousService')
                ->setChoices(function ($entity) {
                    $type = $entity->getType(); // Obtenez le type sélectionné
                    $sousServices = [];
                    if ($type === 'mecanique') {
                        $sousServices = [
                            'Moteur' => 'moteur',
                            'Système de freinage' => 'systeme_freinage',
                            'Système d\'échappement' => 'systeme_echappement',
                            'Suspension, amortisseur' => 'suspension_amortisseur',
                            'Pneumatique' => 'pneumatique',
                        ];
                    } elseif ($type === 'entretien') {
                        $sousServices = [
                            'Vidange et filtre' => 'vidange_filtre',
                            'Pneu et frein' => 'pneu_frein',
                            'Diagnostic électrique' => 'diagnostic_electrique',
                            'Batterie' => 'batterie',
                        ];
                    } elseif ($type === 'carrosserie') {
                        $sousServices = [
                            'Ponçage et peinture' => 'poncage_peinture',
                            'Réparation carrosserie' => 'reparation_carrosserie',
                            'Remplacement d\'élément' => 'remplacement_element',
                        ];
                    }
                    return $sousServices;
                })
                ->setRequired(true),
            TextEditorField::new('description'),
        ];
    }
}

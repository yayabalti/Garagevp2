<?php 

// namespace App\Controller\Admin;

// use App\Entity\Car;
// use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
// use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
// use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

// class CarCrudController extends AbstractCrudController
// {
//     public static function getEntityFqcn(): string
//     {
//         return Car::class;
//     }

//     public function configureFields(string $pageName): iterable
//     {
//         return [
//             IdField::new('id')->hideOnForm(),
//             TextField::new('model', 'Modèle')->setRequired(true),
//             TextField::new('brand', 'Marque')->setRequired(true),
//             IntegerField::new('year', 'Année')->setRequired(true),
//             ChoiceField::new('engineType', 'Type de carburant')
//                 ->setChoices([
//                     'Diesel' => 'diesel',
//                     'Essence' => 'essence',
//                 ])
//                 ->setRequired(true),
//             IntegerField::new('mileage', 'Kilométrage')->setRequired(true),
//             MoneyField::new('price', 'Prix')->setCurrency('EUR')->setRequired(true),
//             ImageField::new('image', 'Image')
//                 ->setBasePath('/uploads')  
//                 ->setUploadDir('public/uploads')
//                 ->setUploadedFileNamePattern('[randomhash].[extension]')
//                 ->setFormTypeOptions([
//                     'attr' => [
//                         'accept' => 'image/*'
//                     ],
//                     'data_class' => null,
//                 ])
//                 ->setRequired(false),
//             TextareaField::new('description', 'Description')->setRequired(true),
//         ];
//     }

//     public function configureCrud(Crud $crud): Crud
//     {
//         return $crud
//             ->setPageTitle('index', 'Gestion des véhicules')
//             ->setPageTitle('new', 'Ajouter un véhicule')
//             ->setPageTitle('edit', 'Modifier un véhicule')
//             ->setDefaultSort(['id' => 'DESC']);
//     }
// }





namespace App\Controller\Admin;

use App\Entity\Car;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class CarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Car::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('model', 'Modèle')->setRequired(true),
            TextField::new('brand', 'Marque')->setRequired(true),
            IntegerField::new('year', 'Année')->setRequired(true),
            ChoiceField::new('engineType', 'Type de carburant')
                ->setChoices([
                    'Diesel' => 'diesel',
                    'Essence' => 'essence',
                ])
                ->setRequired(true),
            IntegerField::new('mileage', 'Kilométrage')->setRequired(true),
            NumberField::new('price', 'Prix')
                ->setFormTypeOption('attr', [
                    'min' => 0,
                    'max' => 1000000,
                    'step' => 0.01
                ])
                ->setRequired(true),
            ImageField::new('image', 'Image')
                ->setBasePath('/uploads')  
                ->setUploadDir('public/uploads')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setFormTypeOptions([
                    'attr' => [
                        'accept' => 'image/*'
                    ],
                    'data_class' => null,
                ])
                ->setRequired(false),
            TextareaField::new('description', 'Description')->setRequired(true),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Gestion des véhicules')
            ->setPageTitle('new', 'Ajouter un véhicule')
            ->setPageTitle('edit', 'Modifier un véhicule')
            ->setDefaultSort(['id' => 'DESC']);
    }
}






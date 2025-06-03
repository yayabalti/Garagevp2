<?php 

//  namespace App\Controller\Admin;

//  use App\Entity\Car;
//  use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
//  use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
//  use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
//  use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
//  use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
//  use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
//  use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
//  use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
//  use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

//  class CarCrudController extends AbstractCrudController
//  {
//      public static function getEntityFqcn(): string
//      {
//          return Car::class;
//      }

//      public function configureFields(string $pageName): iterable
//      {
//          return [
//              IdField::new('id')->hideOnForm(),
//             TextField::new('model', 'Modèle')->setRequired(true),
//              TextField::new('brand', 'Marque')->setRequired(true),
//              IntegerField::new('year', 'Année')->setRequired(true),  
//              ChoiceField::new('engineType', 'Type de carburant')
//                  ->setChoices([
//                      'Diesel' => 'diesel',
//                      'Essence' => 'essence',
//                  ])
//                  ->setRequired(true),
//              IntegerField::new('mileage', 'Kilométrage')->setRequired(true),
//              NumberField::new('price', 'Prix')
//                  ->setFormTypeOption('attr', [
//                      'min' => 0,
//                      'max' => 1000000,
//                      'step' => 0.01
//                  ])
//                  ->setRequired(true),
//              ImageField::new('image', 'Image')
//                  ->setBasePath('/')  
//                  ->setUploadDir('public/uploads/')
//                  ->setUploadedFileNamePattern('[randomhash].[extension]')
//                  ->setFormTypeOptions([
//                      'attr' => [
//                          'accept' => 'image/*'
//                      ],
//                      'data_class' => null,
//                  ])
//                  ->setRequired(false),
//              TextareaField::new('description', 'Description')->setRequired(true),
//          ];
//      }

//      public function configureCrud(Crud $crud): Crud
//      {
//          return $crud
//              ->setPageTitle('index', 'Gestion des véhicules')
//              ->setPageTitle('new', 'Ajouter un véhicule')
//              ->setPageTitle('edit', 'Modifier un véhicule')
//              ->setDefaultSort(['id' => 'DESC']);
//      }
//  }





// namespace App\Controller\Admin;

// use App\Entity\Car;
// use Doctrine\ORM\EntityManagerInterface;
// use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
// use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
// use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
// use Symfony\Component\HttpFoundation\File\UploadedFile;
// use Symfony\Component\Validator\Validator\ValidatorInterface;


// class CarCrudController extends AbstractCrudController
// {
//    private $entityManager;
//    private $validator; // Ajoutez cette propriété

//    // Remplacez le constructeur actuel par celui-ci
//    public function __construct(
//        EntityManagerInterface $entityManager, 
//        ValidatorInterface $validator
//    ) {
//        $this->entityManager = $entityManager;
//        $this->validator = $validator;
//    }

//    public static function getEntityFqcn(): string
//    {
//        return Car::class;
//    }


//    public function configureFields(string $pageName): iterable
// {
//     return [
//         IdField::new('id')->hideOnForm(),
//         TextField::new('model', 'Modèle')->setRequired(true),
//         ChoiceField::new('brand', 'Marque')
//             ->setRequired(true)
//             ->setChoices([
//                 'Peugeot' => 'Peugeot',
//                 'Renault' => 'Renault',
//                 'Audi' => 'Audi',
//                 'BMW' => 'BMW',
//                 'Mercedes' => 'Mercedes',
//                 'Opel' => 'Opel',
//                 'Dacia' => 'Dacia',
//                 'Volkswagen' => 'Volkswagen',
//                 'Citroën' => 'Citroën',
//                 'Porsche' => 'Porsche',
//                 'Toyota' => 'Toyota',
//                 'Ford' => 'Ford',
//                 'Seat' => 'Seat'
//             ]),
//         IntegerField::new('year', 'Année')->setRequired(true),  
//         ChoiceField::new('engineType', 'Type de carburant')
//             ->setChoices([
//                 'Diesel' => 'diesel',
//                 'Essence' => 'essence',
//             ])
//             ->setRequired(true),
//         IntegerField::new('mileage', 'Kilométrage')->setRequired(true),
//         NumberField::new('price', 'Prix')
//             ->setFormTypeOption('attr', [
//                 'min' => 0,
//                 'max' => 1000000,
//                 'step' => 0.01
//             ])
//             ->setRequired(true),
//         ImageField::new('image', 'Image')
//             ->setBasePath('/')  
//             ->setUploadDir('public/uploads/')
//             ->setUploadedFileNamePattern('[randomhash].[extension]')
//             ->setFormTypeOptions([
//                 'attr' => [
//                     'accept' => 'image/*'
//                 ],
//                 'data_class' => null,
//             ])
//             ->setRequired(false),
//         TextareaField::new('description', 'Description')->setRequired(true),
//     ];
// }

//    public function configureCrud(Crud $crud): Crud
//    {
//        return $crud
//            ->setPageTitle('index', 'Gestion des véhicules')
//            ->setPageTitle('new', 'Ajouter un véhicule')
//            ->setPageTitle('edit', 'Modifier un véhicule')
//            ->setDefaultSort(['id' => 'DESC']);
//    }

//    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
//     {
//         if (!$entityInstance instanceof Car) {
//             return;
//         }

//         try {
//             $this->handleImageUpload($entityInstance);
//             $entityManager->persist($entityInstance);
//             $entityManager->flush();
//             error_log("Entité Car persistée avec succès. ID: " . $entityInstance->getId());
//         } catch (\Exception $e) {
//             error_log("Erreur lors de la persistance de l'entité Car: " . $e->getMessage());
//             throw $e;
//         }
        
//     }
   
//     public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
//     {
//         if (!$entityInstance instanceof Car) {
//             return;
//         }

//         try {
//             $this->handleImageUpload($entityInstance);
//             $entityManager->flush();
//             error_log("Entité Car mise à jour avec succès. ID: " . $entityInstance->getId());
//         } catch (\Exception $e) {
//             error_log("Erreur lors de la mise à jour de l'entité Car: " . $e->getMessage());
//             throw $e;
//         }
//     }

//     private function handleImageUpload(Car $car): void
//     {
//         $imageFile = $car->getImageFile();
//         if ($imageFile instanceof UploadedFile) {
//             $newFilename = uniqid() . '.' . $imageFile->getClientOriginalExtension();
//             try {
//                 $imageFile->move('public/uploads', $newFilename);
//                 $car->setImage('uploads/' . $newFilename);
//             } catch (\Exception $e) {
//                 throw new \Exception('Erreur lors de l\'upload de l\'image : ' . $e->getMessage());
//             }
//         }
//     }

   
// }




namespace App\Controller\Admin;

use App\Entity\Car;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CarCrudController extends AbstractCrudController
{
    private $entityManager;
    private $validator;

    public function __construct(
        EntityManagerInterface $entityManager, 
        ValidatorInterface $validator
    ) {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function createEntity(string $entityFqcn)
    {
        $car = new Car();
        return $car;
    }

    public static function getEntityFqcn(): string
    {
        return Car::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-edit')->setLabel('Modifier');
            });
    }

    public function configureFields(string $pageName): iterable
    {
        error_log('=== configureFields appelé ===');
        return [
            IdField::new('id')
            ->hideOnForm()
            ->hideOnIndex(),
            TextField::new('model', 'Modèle')
                ->setRequired(true),
            ChoiceField::new('brand', 'Marque')
                ->setRequired(true)
                ->setChoices([
                    'Peugeot' => 'Peugeot',
                    'Renault' => 'Renault',
                    'Audi' => 'Audi',
                    'BMW' => 'BMW',
                    'Mercedes' => 'Mercedes',
                    'Opel' => 'Opel',
                    'Dacia' => 'Dacia',
                    'Volkswagen' => 'Volkswagen',
                    'Citroën' => 'Citroën',
                    'Porsche' => 'Porsche',
                    'Toyota' => 'Toyota',
                    'Ford' => 'Ford',
                    'Seat' => 'Seat'
                ]),
            IntegerField::new('year', 'Année')
                ->setRequired(true),
            ChoiceField::new('engineType', 'Type de carburant')
                ->setChoices([
                    'Diesel' => 'diesel',
                    'Essence' => 'essence',
                ])
                ->setRequired(true),
            IntegerField::new('mileage', 'Kilométrage')
                ->setRequired(true),
            NumberField::new('price', 'Prix')
                ->setNumDecimals(2)
                ->setFormTypeOption('attr', [
                    'min' => 0,
                    'max' => 1000000,
                    'step' => 0.01
                ])
                ->setRequired(true),
            ImageField::new('image', 'Image')
                ->setBasePath('/uploads/')
                ->setUploadDir('public/uploads/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setFormTypeOptions([
                    'attr' => [
                        'accept' => 'image/*'
                    ],
                    'data_class' => null,
                ])
                ->setRequired(false),
            TextareaField::new('description', 'Description')
                ->setRequired(true),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', 'Gestion des véhicules')
            ->setPageTitle('new', 'Ajouter un véhicule')
            ->setPageTitle('edit', 'Modifier un véhicule')
            ->setPageTitle('detail', 'Détails du véhicule')
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        error_log('=== DÉBUT persistEntity ===');
        
        if (!$entityInstance instanceof Car) {
            error_log('ERREUR: L\'entité n\'est pas une voiture');
            return;
        }
    
        try {
            // Vérifier que l'ID est bien null avant la persistance
            if ($entityInstance->getId() !== null) {
                error_log('ID avant persistance non null: ' . $entityInstance->getId());
            }
    
            // Gérer l'image
            $this->handleImageUpload($entityInstance);
            
            // Persistance avec un try/catch spécifique
            try {
                $entityManager->persist($entityInstance);
                $entityManager->flush();
                error_log('Voiture créée avec ID: ' . $entityInstance->getId());
            } catch (\Exception $e) {
                error_log('ERREUR pendant la persistance: ' . $e->getMessage());
                throw $e;
            }
    
        } catch (\Exception $e) {
            error_log('ERREUR CRITIQUE: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        error_log('=== DÉBUT updateEntity ===');
        
        if (!$entityInstance instanceof Car) {
            error_log('ERREUR: L\'entité n\'est pas une voiture');
            return;
        }

        try {
            $this->handleImageUpload($entityInstance);
            
            $violations = $this->validator->validate($entityInstance);
            if (count($violations) > 0) {
                error_log('Erreurs de validation: ' . (string) $violations);
                throw new \Exception((string) $violations);
            }

            $entityManager->flush();
            error_log('Mise à jour réussie - ID: ' . $entityInstance->getId());
            
        } catch (\Exception $e) {
            error_log('ERREUR lors de la mise à jour: ' . $e->getMessage());
            throw $e;
        }
    }

    private function handleImageUpload(Car $car): void
    {
        error_log('=== DÉBUT handleImageUpload ===');
        
        $imageFile = $car->getImageFile();
        if (!$imageFile instanceof UploadedFile) {
            error_log('Pas de nouvelle image à uploader');
            return;
        }

        try {
            $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilename = $originalFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();
            
            error_log('Tentative d\'upload de l\'image: ' . $newFilename);
            
            $imageFile->move('public/uploads', $newFilename);
            $car->setImage($newFilename);
            
            error_log('Image uploadée avec succès');
            
        } catch (\Exception $e) {
            error_log('ERREUR upload image: ' . $e->getMessage());
            throw new \Exception('Erreur lors de l\'upload de l\'image : ' . $e->getMessage());
        }
    }
}





<?php

namespace App\Controller\Admin;

use App\Entity\Service;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\ORM\EntityManagerInterface;

class ServiceCrudController extends AbstractCrudController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getEntityFqcn(): string
    {
        return Service::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nom'),
            ChoiceField::new('categorie')
                ->setChoices([
                    'Mécanique' => 'mecanique',
                    'Entretien' => 'entretien',
                    'Carrosserie' => 'carrosserie',
                ])
                ->setRequired(true),
            TextEditorField::new('description'),
            ImageField::new('imageFilename')
                ->setBasePath('uploads/services')
                ->setUploadDir('public/uploads/services')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false)
                ->setLabel('Image du service'),
            DateTimeField::new('createdAt')
                ->setLabel('Date de création')
                ->hideOnForm(),
            DateTimeField::new('updatedAt')
                ->setLabel('Dernière modification')
                ->hideOnForm(),
        ];
    }

    public function createEntity(string $entityFqcn)
    {
        $service = new Service();
        return $service;
    }

    public function prePersist(EntityManagerInterface $entityManager, $entityInstance): void
    {
        if ($entityInstance instanceof Service) {
            $entityInstance->setUpdatedAt(new \DateTimeImmutable());
            $this->entityManager->persist($entityInstance);
            $this->entityManager->flush();
        }
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Service')
            ->setEntityLabelInPlural('Services')
            ->setDefaultSort(['createdAt' => 'DESC']);
    }
}
<?php
// namespace App\Controller;

// use App\Entity\Review;
// use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
// use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
// use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
// use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
// use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

// class EmployeReviewCrudController extends AbstractCrudController
// {
//     public static function getEntityFqcn(): string
//     {
//         return Review::class;
//     }

//     public function configureCrud(Crud $crud): Crud
//     {
//         return $crud
//             ->setEntityLabelInSingular('Avis')
//             ->setEntityLabelInPlural('Avis')
//             ->setSearchFields(['firstname', 'lastname', 'email', 'comment'])
//             ->setDefaultSort(['createdAt' => 'DESC']);
//     }

//     public function configureFields(string $pageName): iterable
//     {
//         return [
//             TextField::new('firstname', 'Prénom')->setRequired(true),
//             TextField::new('lastname', 'Nom')->setRequired(true),
//             EmailField::new('email', 'E-mail')->setRequired(true),
//             IntegerField::new('rating', 'Note')
//                 ->setHelp('Note sur 5')
//                 ->setFormTypeOption('attr', ['min' => 1, 'max' => 5]),
//             TextareaField::new('comment', 'Commentaire')->setRequired(true),
//             BooleanField::new('approved', 'Approuvé')
//                 ->setHelp('Cochez pour afficher l\'avis sur le site'),
//             DateTimeField::new('createdAt', 'Date de création')
//                 ->setFormTypeOption('disabled', true)
//         ];
//     }

//     public function configureActions(Actions $actions): Actions
//     {
//         return $actions
//             ->add(Crud::PAGE_INDEX, Action::DETAIL)
//             ->setPermissions([
//                 Action::INDEX => 'ROLE_EMPLOYEE',
//                 Action::EDIT => 'ROLE_EMPLOYEE',
//                 Action::NEW => 'ROLE_EMPLOYEE',
//                 Action::DELETE => 'ROLE_EMPLOYEE',
//                 Action::DETAIL => 'ROLE_EMPLOYEE'
//             ]);
//     }
// }



namespace App\Controller;

use App\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/easyemploye/dashboard')]
class EmployeReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Avis')
            ->setEntityLabelInPlural('Avis')
            ->setSearchFields(['firstname', 'lastname', 'email', 'comment'])
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('firstname', 'Prénom')->setRequired(true),
            TextField::new('lastname', 'Nom')->setRequired(true),
            EmailField::new('email', 'E-mail')->setRequired(true),
            IntegerField::new('rating', 'Note')
                ->setHelp('Note sur 5')
                ->setFormTypeOption('attr', ['min' => 1, 'max' => 5]),
            TextareaField::new('comment', 'Commentaire')->setRequired(true),
            BooleanField::new('approved', 'Approuvé')
                ->setHelp('Cochez pour afficher l\'avis sur le site'),
            DateTimeField::new('createdAt', 'Date de création')
                ->setFormTypeOption('disabled', true)
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::INDEX)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->setPermissions([
                Action::INDEX => 'ROLE_EMPLOYE',
                Action::EDIT => 'ROLE_EMPLOYE',
                Action::NEW => 'ROLE_EMPLOYE',
                Action::DELETE => 'ROLE_EMPLOYE',
                Action::DETAIL => 'ROLE_EMPLOYE'
            ]);
    }
}

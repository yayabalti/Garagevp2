<?php
namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField; 
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

class UserCrudController extends AbstractCrudController
{
   private $passwordHasher;

   public function __construct(UserPasswordHasherInterface $passwordHasher)
   {
       $this->passwordHasher = $passwordHasher;
   }

   public static function getEntityFqcn(): string
   {
       return User::class;
   }

   public function configureActions(Actions $actions): Actions
   {
       return $actions
           ->add(Crud::PAGE_INDEX, Action::DETAIL)
           ->disable(Action::DELETE);
   }

   public function configureFields(string $pageName): iterable
   {
       return [
           EmailField::new('email'),
           TextField::new('firstName', 'Prénom'),
           TextField::new('lastName', 'Nom'),
           TextField::new('password', 'Mot de passe')
               ->setFormType(PasswordType::class)
               ->onlyWhenCreating(),
           ChoiceField::new('roles')
               ->setChoices([
                   'Employé' => 'ROLE_EMPLOYE',
                   'Administrateur' => 'ROLE_ADMIN'
               ])
               ->allowMultipleChoices()
               ->renderAsBadges(),
           BooleanField::new('isActive', 'Actif')
       ];
   }

   public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
   {
       if (!$entityInstance instanceof User) return;

       if ($entityInstance->getPassword()) {
           $hashedPassword = $this->passwordHasher->hashPassword(
               $entityInstance,
               $entityInstance->getPassword()
           );
           $entityInstance->setPassword($hashedPassword);
       }

       parent::persistEntity($entityManager, $entityInstance);
   }

   public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
   {
       if (!$entityInstance instanceof User) return;

       if ($entityInstance->getPassword()) {
           $hashedPassword = $this->passwordHasher->hashPassword(
               $entityInstance,
               $entityInstance->getPassword()
           );
           $entityInstance->setPassword($hashedPassword);
       }

       parent::updateEntity($entityManager, $entityInstance);
   }
}
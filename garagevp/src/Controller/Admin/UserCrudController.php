<?php

// namespace App\Controller\Admin;

// use App\Entity\User;
// use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
// use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
// use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
// use Symfony\Component\Form\Extension\Core\Type\PasswordType;
// use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
// use Doctrine\ORM\EntityManagerInterface;
// use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
// use EasyCorp\Bundle\EasyAdminBundle\Config\Actions; 
// use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
// use Symfony\Bundle\SecurityBundle\Security;


// class UserCrudController extends AbstractCrudController
// {
   
//    private $passwordHasher;
//    private $security;

   
//    public function __construct(
//        UserPasswordHasherInterface $passwordHasher,
//        Security $security
//    ) {
//        $this->passwordHasher = $passwordHasher;
//        $this->security = $security;
//    }

//    // Définit l'entité gérée par ce contrôleur CRUD
//    public static function getEntityFqcn(): string
//    {
//        return User::class;
//    }

//    // Configure les actions disponibles dans l'interface
//    public function configureActions(Actions $actions): Actions
//    {
//        return $actions
           
//            ->add(Crud::PAGE_INDEX, Action::DETAIL)
           
//            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
//                return $action->setIcon('fa fa-edit')->setLabel('Modifier');
//            })
//            // Configure la suppression avec une condition
//            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
//                return $action->displayIf(static function (User $user) {
//                    // Empêche la suppression des administrateurs
//                    return !in_array('ROLE_ADMIN', $user->getRoles());
//                });
//            });
//    }

//    // Configure les champs à afficher dans les formulaires
//    public function configureFields(string $pageName): iterable
//    {
//        $fields = [
           
//            EmailField::new('email')
//                ->setRequired(true),
           
//            TextField::new('firstName', 'Prénom')
//                ->setRequired(true),
          
//            TextField::new('lastName', 'Nom')
//                ->setRequired(true),
           
//            TextField::new('password', 'Mot de passe')
//                ->setFormType(PasswordType::class)
//                ->setRequired($pageName === Crud::PAGE_NEW)
//                ->onlyWhenCreating(),
//            // Sélection des rôles avec choix multiples
//            ChoiceField::new('roles')
//                ->setChoices([
//                    'Employé' => 'ROLE_EMPLOYE',
//                    'Administrateur' => 'ROLE_ADMIN'
//                ])
//                ->allowMultipleChoices()
//                ->renderAsBadges()
//                ->setRequired(true),
           
//            BooleanField::new('isActive', 'Actif')
//                ->setRequired(true)
//        ];

//        // Masque la gestion des rôles pour les non-administrateurs
//        if (!$this->security->isGranted('ROLE_ADMIN')) {
//            unset($fields[4]);
//        }

//        return $fields;
//    }

//    // Gère la création d'un nouvel utilisateur
//    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
//    {
//        if (!$entityInstance instanceof User) return;

//        // Active le compte par défaut
//        if (!$entityInstance->isActive()) {
//            $entityInstance->setIsActive(true);
//        }

//        // Hache le mot de passe avant l'enregistrement
//        $plainPassword = $entityInstance->getPassword();
//        if ($plainPassword) {
//            $hashedPassword = $this->passwordHasher->hashPassword(
//                $entityInstance,
//                $plainPassword
//            );
//            $entityInstance->setPassword($hashedPassword);
//        }

//        // Attribue le rôle EMPLOYE par défaut
//        $roles = $entityInstance->getRoles();
//        if (empty($roles)) {
//            $entityInstance->setRoles(['ROLE_EMPLOYE']);
//        }

//        // Appelle la méthode parente pour terminer la persistance
//        parent::persistEntity($entityManager, $entityInstance);
//    }

//    // Gère la mise à jour d'un utilisateur existant
//    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
//    {
//        if (!$entityInstance instanceof User) return;

//        // Hache le nouveau mot de passe si modifié
//        $plainPassword = $entityInstance->getPassword();
//        if ($plainPassword) {
//            $hashedPassword = $this->passwordHasher->hashPassword(
//                $entityInstance,
//                $plainPassword
//            );
//            $entityInstance->setPassword($hashedPassword);
//        }

//        // Appelle la méthode parente pour terminer la mise à jour
//        parent::updateEntity($entityManager, $entityInstance);
//    }
// }


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
use Symfony\Bundle\SecurityBundle\Security;

class UserCrudController extends AbstractCrudController
{
    private $passwordHasher;
    private $security;

    public function __construct(
        UserPasswordHasherInterface $passwordHasher,
        Security $security
    ) {
        $this->passwordHasher = $passwordHasher;
        $this->security = $security;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fa fa-edit')->setLabel('Modifier');
            })
            ->update(Crud::PAGE_INDEX, Action::DELETE, function (Action $action) {
                return $action->displayIf(static function (User $user) {
                    return !in_array('ROLE_ADMIN', $user->getRoles());
                });
            });
    }

    public function configureFields(string $pageName): iterable
    {
        $fields = [
            EmailField::new('email')
                ->setRequired(true),
            
            TextField::new('firstName', 'Prénom')
                ->setRequired(true),
            
            TextField::new('lastName', 'Nom')
                ->setRequired(true),
            
            TextField::new('password', 'Mot de passe')
                ->setFormType(PasswordType::class)
                ->setRequired($pageName === Crud::PAGE_NEW)
                ->onlyWhenCreating(),
            
            ChoiceField::new('roles')
                ->setChoices([
                    'Employé' => 'ROLE_EMPLOYE',
                    'Administrateur' => 'ROLE_ADMIN'
                ])
                ->allowMultipleChoices()
                ->renderAsBadges()
                ->setRequired(true),
            
            BooleanField::new('isActive', 'Actif')
                ->setRequired(true)
        ];

        if (!$this->security->isGranted('ROLE_ADMIN')) {
            unset($fields[4]);
        }

        return $fields;
    }

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
{
    
    error_log('persistEntity appelé');

    if (!$entityInstance instanceof User) return;

    try {
        // Active le compte par défaut
        $entityInstance->setIsActive(true);

        // Vérification du mot de passe avant de le hasher
        $plainPassword = $entityInstance->getPassword();
        if (!empty($plainPassword)) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $entityInstance,
                $plainPassword
            );
            $entityInstance->setPassword($hashedPassword);
        }

        // Persiste et enregistre l'utilisateur
        $entityManager->persist($entityInstance);
        $entityManager->flush();  // Enregistre les modifications dans la base de données

        error_log('Utilisateur créé avec succès - Email: ' . $entityInstance->getEmail());
    } catch (\Exception $e) {
        error_log('ERREUR création utilisateur: ' . $e->getMessage());
        throw $e;
    }
}



public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
{
    if (!$entityInstance instanceof User) return;

    try {
        error_log('Début de la mise à jour d\'un utilisateur');

        // Vérifie si un nouveau mot de passe a été saisi avant de le hasher
        $plainPassword = $entityInstance->getPassword();
        if (!empty($plainPassword)) {
            $hashedPassword = $this->passwordHasher->hashPassword(
                $entityInstance,
                $plainPassword
            );
            $entityInstance->setPassword($hashedPassword);
            error_log('Mot de passe mis à jour');
        } else {
            // Récupérer l'ancien mot de passe si aucun nouveau n'est fourni
            $oldUser = $entityManager->getRepository(User::class)->find($entityInstance->getId());
            if ($oldUser) {
                $entityInstance->setPassword($oldUser->getPassword());
                error_log('Ancien mot de passe conservé');
            }
        }

        // Ne pas modifier les rôles si non changés
        if (empty($entityInstance->getRoles())) {
            $oldUser = $entityManager->getRepository(User::class)->find($entityInstance->getId());
            if ($oldUser) {
                $entityInstance->setRoles($oldUser->getRoles());
                error_log('Ancien rôle conservé');
            }
        }

        $entityManager->flush();
        error_log('Utilisateur mis à jour avec succès - ID: ' . $entityInstance->getId());

    } catch (\Exception $e) {
        error_log('ERREUR mise à jour utilisateur: ' . $e->getMessage());
        throw $e;
    }
}
}
<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Utilisateur')
            ->setEntityLabelInPlural('Utilisateurs')
            ->showEntityActionsInlined()
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('full_name', 'Nom')->onlyOnIndex();
        yield TextField::new('firstName', 'Prénom')->onlyWhenCreating();
        yield TextField::new('lastName', 'Nom')->onlyWhenCreating();
        yield TextField::new('email', 'E-Mail');
        yield ArrayField::new('roles', 'Rôles');
        yield DateField::new('created_at', 'Date de création')
            ->onlyOnIndex();
        yield DateField::new('updated_at', 'Dernière modification')
            ->onlyOnIndex();
    }

}

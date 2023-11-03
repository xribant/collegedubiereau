<?php

namespace App\Controller\Admin;

use App\Entity\InfoRegistration;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;

class InfoRegistrationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InfoRegistration::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $registration = new InfoRegistration();

        return $registration;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Inscription')
            ->setEntityLabelInPlural('Inscriptions')
            ->showEntityActionsInlined()
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
            ->add(Crud::PAGE_DETAIL, Action::DETAIL)
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('firstName', 'Prénom');
        yield TextField::new('lastName', 'Nom');
        yield EmailField::new('email', 'E-Mail');
        yield EmailField::new('phone', 'Téléphone');
        yield DateField::new('created_at', 'Date d\'inscription')
            ->onlyOnIndex();
    }
    
}

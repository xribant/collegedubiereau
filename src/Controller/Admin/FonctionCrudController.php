<?php

namespace App\Controller\Admin;

use App\Entity\Fonction;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class FonctionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Fonction::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $fonction = new Fonction();
        $fonction->setLastModifiedBy($this->getUser()->getFullName());

        return $fonction;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Fonction')
            ->setEntityLabelInPlural('Fonctions')
            ->showEntityActionsInlined()
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Intitulé de la fonction');
        yield DateField::new('created_at', 'Date de création')
            ->onlyOnIndex();
        yield DateField::new('updated_at', 'Dernière modification')
            ->onlyOnIndex();
        yield TextField::new('last_modified_by', 'Modifié par')
            ->onlyOnIndex();
    }
}

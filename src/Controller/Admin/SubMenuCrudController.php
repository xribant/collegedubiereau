<?php

namespace App\Controller\Admin;

use App\Entity\SubMenu;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class SubMenuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubMenu::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $menu = new SubMenu();
        $menu->setLastModifiedBy($this->getUser()->getFullName());

        return $menu;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Sous-Menu')
            ->setEntityLabelInPlural('Sous-Menus')
            ->showEntityActionsInlined()
        ;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom du sous-menu');
        yield AssociationField::new('parent_menu', 'Menu parent');
        yield DateField::new('created_at', 'Date de création')
            ->onlyOnIndex();
        yield DateField::new('updated_at', 'Dernière modification')
            ->onlyOnIndex();
        yield TextField::new('last_modified_by', 'Modifié par')
            ->onlyOnIndex();
    }

}

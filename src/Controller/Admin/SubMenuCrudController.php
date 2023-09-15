<?php

namespace App\Controller\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;

use App\Entity\SubMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;

class SubMenuCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SubMenu::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Sous-Menu')
            ->setEntityLabelInPlural('Sous-Menus')
            ->setPageTitle('index', 'Gestion des sous-menus')
            ->setDefaultSort(['position' => 'ASC'])
            ->showEntityActionsInlined();
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            AssociationField::new('parent_menu','Menu Principal')
                ->onlyOnIndex()
                ->setCrudController(MenuCrudController::class),
            AssociationField::new('page','Page')
                ->setCrudController(PageCrudController::class),
            DateTimeField::new('created_at','Date de création')->hideOnForm(),
            DateTimeField::new('updated_at', 'Dernière modification')->hideOnForm(),
        ];
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('parent_menu', 'Menu Principal'))
        ;
    }
}

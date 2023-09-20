<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class PageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $page = new Page();
        $page->setLastModifiedBy($this->getUser()->getFullName());
        $page->setPath('/'.$page->getSlug());

        return $page;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Page')
            ->setEntityLabelInPlural('Pages')
            ->showEntityActionsInlined()
        ;
    }


    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('title', 'Titre');
        yield AssociationField::new('parent_menu', 'Menu de navigation');
        yield BooleanField::new('published', 'Publiée')
            ->onlyOnIndex();
        yield DateField::new('created_at', 'Date de création')
            ->onlyOnIndex();
        yield DateField::new('updated_at', 'Dernière modification')
            ->onlyOnIndex();
        yield TextField::new('last_modified_by', 'Modifié par')
            ->onlyOnIndex();
    }
}

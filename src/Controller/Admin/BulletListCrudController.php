<?php

namespace App\Controller\Admin;

use App\Entity\BulletList;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use PhpParser\ErrorHandler\Collecting;

class BulletListCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BulletList::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $list = new BulletList();
        $list->setLastModifiedBy($this->getUser()->getFullName());

        return $list;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Liste')
            ->setEntityLabelInPlural('Listes')
            ->showEntityActionsInlined()
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('parent_page', 'Liée à la page');
        yield CollectionField::new('bullets', 'Elements de liste')
            ->onlyOnIndex();
        yield TextField::new('name', 'Titre de cette liste');
        yield DateField::new('created_at', 'Date de création')
            ->onlyOnIndex();
        yield DateField::new('updated_at', 'Dernière modification')
            ->onlyOnIndex();
        yield TextField::new('last_modified_by', 'Modifié par')
            ->onlyOnIndex();
    }

}

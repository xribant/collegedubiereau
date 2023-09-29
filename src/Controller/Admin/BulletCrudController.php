<?php

namespace App\Controller\Admin;

use App\Entity\Bullet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;

class BulletCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Bullet::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $bullet = new Bullet();
        $bullet->setLastModifiedBy($this->getUser()->getFullName());
        $bullet->setPosition(1);

        return $bullet;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Elément de liste')
            ->setEntityLabelInPlural('Eléments de liste')
            ->showEntityActionsInlined()
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('parent_list')
        ;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield NumberField::new('number', 'Numéro d\'ordre');
        yield TextField::new('title', 'Titre de cet élément');
        yield AssociationField::new('parent_list', 'Liste');
        yield TextEditorField::new('text', 'Texte')
            ->onlyOnForms();
        yield DateField::new('created_at', 'Date de création')
            ->onlyOnIndex();
        yield DateField::new('updated_at', 'Dernière modification')
            ->onlyOnIndex();
        yield TextField::new('last_modified_by', 'Modifié par')
            ->onlyOnIndex();
    }
    
}

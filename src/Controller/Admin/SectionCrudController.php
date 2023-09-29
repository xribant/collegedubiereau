<?php

namespace App\Controller\Admin;

use App\Entity\Section;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;

class SectionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Section::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $section = new Section();
        $section->setLastModifiedBy($this->getUser()->getFullName());

        return $section;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Section')
            ->setEntityLabelInPlural('Sections')
            ->showEntityActionsInlined()
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('short_name', 'Section abrégée');
        yield TextField::new('full_name', 'Nom complet de la section');
        yield DateField::new('created_at', 'Date de création')
            ->onlyOnIndex();
        yield DateField::new('updated_at', 'Dernière modification')
            ->onlyOnIndex();
        yield TextField::new('last_modified_by', 'Modifié par')
            ->onlyOnIndex();
    }

}

<?php

namespace App\Controller\Admin;

use App\Entity\Member;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use Vich\UploaderBundle\Form\Type\VichImageType;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class MemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Member::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $member = new Member();
        $member->setLastModifiedBy($this->getUser()->getFullName());

        return $member;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Membre')
            ->setEntityLabelInPlural('Membres')
            ->showEntityActionsInlined()
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('section', 'Section')
            ->onlyOnForms();
        yield TextField::new('firstName', 'Prénom');
        yield TextField::new('lastName', 'Nom');
        yield AssociationField::new('fonction', 'Fonction');
        yield TextField::new('image_file', 'Photo')
            ->setFormType(VichImageType::class)
            ->onlyOnForms();
        yield ImageField::new('image_name','Photo')
            ->setBasePath('/images/member')
            ->setUploadDir('/public/images/member')
            ->onlyOnIndex();
        yield DateField::new('created_at', 'Date de création')
            ->onlyOnIndex();
        yield DateField::new('updated_at', 'Dernière modification')
            ->onlyOnIndex();
        yield TextField::new('last_modified_by', 'Modifié par')
            ->onlyOnIndex();
    }
}

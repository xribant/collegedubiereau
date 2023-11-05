<?php

namespace App\Controller\Admin;

use App\Entity\InfoSessionDay;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;


class InfoSessionDayCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return InfoSessionDay::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $infoDay = new InfoSessionDay();
        $infoDay->setLastModifiedBy($this->getUser()->getFullName());

        return $infoDay;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Journée d\'info')
            ->setEntityLabelInPlural('Journées d\'info')
            ->showEntityActionsInlined()
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        yield DateTimeField::new('session_date', 'Date de la journée d\'info');
        yield BooleanField::new('enabled', 'Activée');
        yield DateField::new('created_at', 'Date de création')
            ->onlyOnIndex();
        yield DateField::new('updated_at', 'Dernière modification')
            ->onlyOnIndex();
        yield TextField::new('last_modified_by', 'Modifié par')
            ->onlyOnIndex();
    }
}

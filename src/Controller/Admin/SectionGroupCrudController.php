<?php

namespace App\Controller\Admin;

use App\Entity\SectionGroup;
use App\Repository\SectionGroupRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use App\Service\AdminIndexPosition;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class SectionGroupCrudController extends AbstractCrudController
{

    public function __construct(
        // private readonly EntityManagerInterface $em,
        private AdminIndexPosition $position,
        private readonly SectionGroupRepository $sectionGroupRepository,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return SectionGroup::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $group = new SectionGroup();
        $group->setLastModifiedBy($this->getUser()->getFullName());

        return $group;
    }

    public function moveUp(AdminContext $context): Response
    {
        return $this->position->moveUp($context);
    }

    public function moveDown(AdminContext $context): Response
    {
        return $this->position->moveDown($context);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Département')
            ->setEntityLabelInPlural('Départements')
            ->showEntityActionsInlined()
            ->setDefaultSort(['position' => 'ASC'])
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        $entityCount = $this->sectionGroupRepository->count([]);

        $moveUp = Action::new('moveUp', false, 'fa fa-sort-up')
            ->setHtmlAttributes(['name' => 'Move up'])
            ->linkToCrudAction('moveUp')
            ->displayIf(fn ($entity) => $entity->getPosition() > 0);

        $moveDown = Action::new('moveDown', false, 'fa fa-sort-down')
            ->setHtmlAttributes(['name' => 'Move down'])
            ->linkToCrudAction('moveDown')
            ->displayIf(fn ($entity) => $entity->getPosition() < $entityCount - 1);

        return $actions
            ->add(Crud::PAGE_INDEX, $moveDown)
            ->add(Crud::PAGE_INDEX, $moveUp);
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name', 'Nom du département');
        yield DateField::new('created_at', 'Date de création')
            ->onlyOnIndex();
        yield DateField::new('updated_at', 'Dernière modification')
            ->onlyOnIndex();
        yield TextField::new('last_modified_by', 'Modifié par')
            ->onlyOnIndex();
    }
}

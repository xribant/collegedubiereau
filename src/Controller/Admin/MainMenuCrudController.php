<?php

namespace App\Controller\Admin;

use App\Entity\MainMenu;
use App\Repository\MainMenuRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\HttpFoundation\Response;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;

enum Direction
{
    case Up;
    case Down;
}

class MainMenuCrudController extends AbstractCrudController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly MainMenuRepository $mainMenuRepository,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return MainMenu::class;
    }

    public function moveUp(AdminContext $context): Response
    {
        return $this->move($context, Direction::Up);
    }

    public function moveDown(AdminContext $context): Response
    {
        return $this->move($context, Direction::Down);
    }

    private function move(AdminContext $context, Direction $direction): Response
    {
        $object = $context->getEntity()->getInstance();
        $newPosition = match($direction) {
            Direction::Up => $object->getPosition() - 1,
            Direction::Down => $object->getPosition() + 1,
        };

        $object->setPosition($newPosition);
        $this->em->flush();

        return $this->redirect($context->getReferrer());
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Menu')
            ->setEntityLabelInPlural('Menus')
            ->showEntityActionsInlined()
            ->setDefaultSort(['position' => 'ASC'])
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        $entityCount = $this->mainMenuRepository->count([]);

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

    public function createEntity(string $entityFqcn)
    {
        $menu = new MainMenu();
        $menu->setLastModifiedBy($this->getUser()->getFullName());

        return $menu;
    }

    
    public function configureFields(string $pageName): iterable
    {
    
        yield TextField::new('name', 'Nom du menu');
        yield CollectionField::new('subMenus', 'Sous-Menus')
            ->onlyOnIndex();
        yield DateField::new('created_at', 'Date de création')
            ->onlyOnIndex();
        yield DateField::new('updated_at', 'Dernière modification')
            ->onlyOnIndex();
        yield TextField::new('last_modified_by', 'Modifié par')
            ->onlyOnIndex();
    }

}

<?php

namespace App\Controller\Admin;

use App\Entity\Menu;
use App\Form\SubMenuType;
use App\Repository\MenuRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;

enum Direction
{
    case Up;
    case Down;
}

class MenuCrudController extends AbstractCrudController
{

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly MenuRepository $sponsorRepository,
    ) {
    }

    public static function getEntityFqcn(): string
    {
        return Menu::class;
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
            ->setPageTitle('index', 'Gestion des menus de navigation')
            ->setDefaultSort(['position' => 'ASC']);
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        $entityCount = $this->sponsorRepository->count([]);

        $moveUp = Action::new('moveUp', false, 'fa fa-sort-up')
            ->setHtmlAttributes(['title' => 'Move up'])
            ->linkToCrudAction('moveUp')
            ->displayIf(fn ($entity) => $entity->getPosition() > 0);

        $moveDown = Action::new('moveDown', false, 'fa fa-sort-down')
            ->setHtmlAttributes(['title' => 'Move down'])
            ->linkToCrudAction('moveDown')
            ->displayIf(fn ($entity) => $entity->getPosition() < $entityCount - 1);

        return $actions
            ->add(Crud::PAGE_INDEX, $moveDown)
            ->add(Crud::PAGE_INDEX, $moveUp);
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnIndex()->hideOnForm(),
            TextField::new('name','Menu Principal'),
            CollectionField::new('subMenus','Sous-Menus')
                ->setEntryType(SubMenuType::class)
                ->setFormTypeOption('by_reference', false),
            DateTimeField::new('created_at','Date de création')->hideOnForm(),
            DateTimeField::new('updated_at', 'Dernière modification')->hideOnForm(),
            
        ];
    }
    
}

<?php

namespace App\Controller\Admin;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use App\Entity\Page;
use App\Entity\Menu;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\ORM\QueryBuilder;


class PageCrudController extends AbstractCrudController
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public static function getEntityFqcn(): string
    {
        return Page::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Page')
            ->setEntityLabelInPlural('Pages')
            ->setPageTitle('index', 'Gestion des Pages');
        ;
    }

    public function configureFields(string $pageName): iterable
    {
        $menuRepository = $this->em->getRepository(Menu::class);

        // Si Menu Parent a des sous menus ou si menu_parent a déjà une page attachée, griser ou cacher le menu
        yield AssociationField::new('parent_menu', 'Lier cette à un menu principal disponible')
            ->onlyOnForms()
            ->setQueryBuilder(
                fn (QueryBuilder $queryBuilder) => $queryBuilder->leftJoin('entity.page', 'page')
                    ->where('entity.subMenus IS EMPTY')
                    ->andWhere('page IS NULL')
                    ->orderBy('entity.name', 'ASC')
            );
        yield AssociationField::new('parent_sub_menu', 'Lier cette à un sous-menu disponible')
        ->onlyOnForms()
        ->setQueryBuilder(
            fn (QueryBuilder $queryBuilder) => $queryBuilder->leftJoin('entity.page', 'page')
                ->where('page IS NULL')
                ->orderBy('entity.name', 'ASC')
            );
        yield AssociationField::new('parent_menu', 'Menu Parent')
            ->onlyOnIndex();
        yield ImageField::new('banner_image', 'Arrière-Plan')
            ->setBasePath('images/page_banner')
            ->setUploadDir('public/images/page_banner');
        yield TextField::new('title', 'Titre')->onlyOnIndex();
        yield DateTimeField::new('created_at','Date de création')->hideOnForm();
        yield DateTimeField::new('updated_at', 'Dernière modification')->hideOnForm();
    }
    
}

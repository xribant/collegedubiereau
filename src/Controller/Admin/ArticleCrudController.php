<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function createEntity(string $entityFqcn)
    {
        $article = new Article();
        $article->setLastModifiedBy($this->getUser()->getFullName());

        return $article;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Article')
            ->setEntityLabelInPlural('Articles')
            ->showEntityActionsInlined()
        ;
    }
    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('parent_page', 'Insérer dans la page');
        yield TextField::new('title', 'Titre de l\'article');
        yield TextEditorField::new('text', 'Texte de l\'article')
            ->setNumOfRows(15)
            ->onlyOnForms();
        yield ChoiceField::new('background_color', 'Couleur d\'arrière-plan')
            ->setChoices([
                'Blanc' => 'none',
                'Gris clair' => 'bg-light',
                'Bleu' => 'bg-info',
                'Vert' => 'bg-teal',
                'Jaune' => 'bg-warning'
            ])
            ->onlyOnForms();
        yield ChoiceField::new('image_position', 'Position de l\'image par rapport au texte')
            ->setChoices([
                'A droite' => 'right',
                'A gauche' => 'left'
            ])
            ->renderAsNativeWidget()
            ->onlyOnForms();
        yield TextField::new('image_file', 'Image')
            ->setFormType(VichImageType::class)
            ->onlyOnForms();
        yield ImageField::new('image_name','Image')
            ->setBasePath('/images/article')
            ->setUploadDir('/public/images/article')
            ->onlyOnIndex();
        yield DateField::new('created_at', 'Date de création')
            ->onlyOnIndex();
        yield DateField::new('updated_at', 'Dernière modification')
            ->onlyOnIndex();
        yield TextField::new('last_modified_by', 'Modifié par')
            ->onlyOnIndex();
    }

}

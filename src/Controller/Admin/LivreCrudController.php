<?php

namespace App\Controller\Admin;
use App\Entity\Langue;
use App\Entity\Categorie;
use App\Entity\Livre;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class LivreCrudController extends AbstractCrudController
{
    use Trait\ShowTrait;
    public static function getEntityFqcn(): string
    {
        return Livre::class;
    }
    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('nom'),
            TextField::new('description')->hideOnIndex(),
            AssociationField::new('categorie')
                ->setCrudController(CategorieCrudController::class)
                ->formatValue(function ($value, $entity) {
                    return $entity->getCategorie()->getNom();
                })
                ->autocomplete(),
            AssociationField::new('review')
                ->setCrudController(ReviewCrudController::class)
                ->autocomplete()
                ->hideOnIndex(),
            NumberField::new('price'),
            NumberField::new('page_num')->hideOnIndex(),
            DateTimeField::new('annee')->hideOnIndex(),
            AssociationField::new('auteur')
                ->setCrudController(AuteurCrudController::class)
                ->formatValue(function ($value, $entity) {
                    return $entity->getAuteur()->getNom();
                })
                ->autocomplete()
                ->hideOnIndex(),
            ImageField::new('image_url')
                ->setUploadDir('public/images/')
                ->setBasePath('images/')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
             
        ];
    }
    
}

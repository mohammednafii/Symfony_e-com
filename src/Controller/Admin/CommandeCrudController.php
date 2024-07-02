<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;

class CommandeCrudController extends AbstractCrudController
{
    use Trait\ShowTrait;
    public static function getEntityFqcn(): string
    {
        return Commande::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnIndex(),
            TextField::new('nom')->hideOnIndex(),
            TextField::new('prenom')->hideOnIndex(),
            TextField::new('reference'),
            DateTimeField::new('created_at'),
            NumberField::new('total'),
            TextField::new('address')->hideOnIndex(),
            BooleanField::new('status'),
        ];
    }
    
}

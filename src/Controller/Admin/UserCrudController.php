<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;

class UserCrudController extends AbstractCrudController
{
    use Trait\ShowTrait;
    public static function getEntityFqcn(): string
    {
        return User::class;
    }




    
    public function configureFields(string $pageName , ): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('password')->onlyOnForms(),
            ArrayField::new('roles'),
        ];
    }
    
}

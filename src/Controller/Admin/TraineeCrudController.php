<?php

namespace App\Controller\Admin;

use App\Entity\Trainee;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TraineeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Trainee::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}

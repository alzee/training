<?php

namespace App\Controller\Admin;

use App\Entity\Trainer;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TrainerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Trainer::class;
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

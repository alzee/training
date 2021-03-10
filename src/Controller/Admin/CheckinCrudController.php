<?php

namespace App\Controller\Admin;

use App\Entity\Checkin;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CheckinCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Checkin::class;
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

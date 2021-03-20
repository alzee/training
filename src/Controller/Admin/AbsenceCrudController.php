<?php

namespace App\Controller\Admin;

use App\Entity\Absence;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;

class AbsenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Absence::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('name')->hideOnForm(),
            DateTimeField::new('leaveAt')->setFormat('y年MM月dd日 HH:mm:ss')->hideOnForm(),
            DateTimeField::new('backAt')->setFormat('y年MM月dd日 HH:mm:ss')->hideOnForm(),
            TextareaField::new('note'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW, Action::DELETE);
        ;
    }
}

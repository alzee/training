<?php

namespace App\Controller\Admin;

use App\Entity\Training;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;

class TrainingCrudController extends AbstractCrudController
{
    //private $statuses = ['计划中' => 0,'进行中' => 1, '已暂停' => 2, '已取消' => 3, '已结束' => 4];

    public static function getEntityFqcn(): string
    {
        return Training::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title'),
            TextareaField::new('description'),
            AssociationField::new('trainer'),
            AssociationField::new('trainees', 'shouldCome'),
            AssociationField::new('status'), //->onlyOnIndex(),
            //ChoiceField::new('status')->setChoices($this->statuses),
            //DateTimeField::new('date')->onlyOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '%entity_label_plural% 列表')
        ;
    }
}

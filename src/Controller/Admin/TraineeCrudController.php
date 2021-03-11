<?php

namespace App\Controller\Admin;

use App\Entity\Trainee;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ArrayFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TraineeCrudController extends AbstractCrudController
{
    private $skills = ['急救护理' => 0,'特殊装备操作' => 1, '机动车驾驶' => 2];
    private $pstatus = ['厨师' => 0,'司机' => 1, '老师' => 2];
    private $politics = ['群众' => 0,'党员' => 1, '军人' => 2];
    private $sex = ['男' => 0,'女' => 1];

    public static function getEntityFqcn(): string
    {
        return Trainee::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name'),
            IntegerField::new('age'),
            ChoiceField::new('sex')->setChoices($this->sex),
            ChoiceField::new('pstatus')->setChoices($this->pstatus),
            ChoiceField::new('politics')->setChoices($this->politics),
            TextField::new('area'),
            TextField::new('phone'),
            TextField::new('address'),
            TextField::new('idnum'),
            ChoiceField::new('skill')->setChoices($this->skills),
        ];
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('area')
            ->add('age')
            ->add(ChoiceFilter::new('pstatus')->setChoices($this->pstatus))
            ->add(ChoiceFilter::new('politics')->setChoices($this->politics))
            ->add(ChoiceFilter::new('skill')->setChoices($this->skills))
        ;
    }
}

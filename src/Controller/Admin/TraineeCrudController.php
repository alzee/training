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
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class TraineeCrudController extends AbstractCrudController
{
    private $skills = ['急救护理' => 0,'特殊装备操作' => 1, '机动车驾驶' => 2];
    private $pstatus = ['民兵' => 0,'退伍军人' => 1, '军人' => 2];
    private $politics = ['群众' => 0,'党员' => 1, '团员' => 2];
    private $sex = ['男' => 0,'女' => 1];
    private $areas = ['宝丰镇' => 0,'城关镇' => 1, '楼塔乡' => 2];

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
            ChoiceField::new('sex')->setChoices($this->sex)->renderExpanded(true),
            ChoiceField::new('pstatus')->setChoices($this->pstatus),
            ChoiceField::new('politics')->setChoices($this->politics),
            ChoiceField::new('area')->setChoices($this->areas),
            TextField::new('phone'),
            TextField::new('address'),
            TextField::new('idnum'),
            AssociationField::new('training'), //->hideOnForm(),
            ChoiceField::new('skills')->setChoices($this->skills)->allowMultipleChoices(true),
            //ArrayField::new('skills'),
            //CollectionField::new('skills'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            //->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('area')
            ->add('age')
            ->add(ChoiceFilter::new('pstatus')->setChoices($this->pstatus)) //->setFormTypeOption('comparison_type', 'ArrayFilter'))
            ->add(ChoiceFilter::new('politics')->setChoices($this->politics))
            ->add(ChoiceFilter::new('skills')->setChoices($this->skills))
            //->add(ChoiceFilter::new('skills')->setChoices($this->skills)->canSelectMultiple(true))
        ;
    }
}

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
            ChoiceField::new('sex')->setChoices(Trainee::$sexes)->renderExpanded(true),
            ChoiceField::new('pstatus')->setChoices(Trainee::$pstatuses),
            ChoiceField::new('politics')->setChoices(Trainee::$allPolitics),
            ChoiceField::new('area')->setChoices(Trainee::$areas),
            TextField::new('phone'),
            TextField::new('address'),
            TextField::new('idnum'),
            AssociationField::new('training'), //->hideOnForm(),
            ChoiceField::new('skills')->setChoices(Trainee::$allSkills)->allowMultipleChoices(true),
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
            ->add(ChoiceFilter::new('pstatus')->setChoices(Trainee::$pstatuses)) //->setFormTypeOption('comparison_type', 'ArrayFilter'))
            ->add(ChoiceFilter::new('politics')->setChoices(Trainee::$allPolitics))
            ->add(ChoiceFilter::new('skills')->setChoices(Trainee::$allSkills))
            //->add(ChoiceFilter::new('skills')->setChoices($this->skills)->canSelectMultiple(true))
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/detail', 'bundles/EasyAdminBundle/crud/detail.html.twig')
        ;
    }
}

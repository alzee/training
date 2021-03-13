<?php

namespace App\Controller\Admin;

use App\Entity\Trainee;
use App\Entity\Training;
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
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;

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
            ImageField::new('image')->setUploadDir('public/images')->setBasePath('/images')->addCssClass('avatar'),
            //AvatarField::new('image'),
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
            ChoiceField::new('skills')->setChoices(Trainee::$allSkills)->allowMultipleChoices(true)->hideOnIndex(),
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
            ->overrideTemplate('crud/index', 'index0.html.twig')
        ;
    }

    public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    {
        if (Crud::PAGE_INDEX === $responseParameters->get('pageName')) {
            // Use findBy([], [...]) hack instead, because findAll() don't have sort
            $trainings = $this->getDoctrine()->getRepository(Training::class)->findBy([],['id'=>'DESC'], 10);
            $responseParameters->set('trainings', $trainings);
        }

        if (Crud::PAGE_DETAIL === $responseParameters->get('pageName')) {
            $traineeId = $responseParameters->get('entity')->getInstance()->getId();
            $trainee = $this->getDoctrine()->getRepository(Trainee::class)->findOneByIdJoinedToTraining($traineeId);
            if(is_null($trainee)){
                $trainings = null;
            }
            else{
                $trainings = $trainee->getTraining();
            }
                $responseParameters->set('trainings', $trainings);
        }

        return $responseParameters;
    }
}

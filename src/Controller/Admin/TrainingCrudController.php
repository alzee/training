<?php

namespace App\Controller\Admin;

use App\Entity\Training;
use App\Entity\Trainee;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;

class TrainingCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Training::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('title'),
            TextareaField::new('description')->setMaxLength(6)->onlyOnIndex(),
            TextareaField::new('description')->hideOnIndex(),
            TextField::new('instructor'),
            AssociationField::new('trainees', 'shouldCome')->hideOnForm(),
            //AssociationField::new('trainees', 'chooseTrainees')->onlyOnForms(),
            AssociationField::new('checkins', 'come')->hideOnForm(),
            DateField::new('startAt')->setFormat('short'),
            DateField::new('endAt')->setFormat('short'),
            //AssociationField::new('status'), //->autocomplete(), //->onlyOnIndex(),
            TextField::new('status0')->hideOnForm(),
            //ChoiceField::new('status')->setChoices($this->statuses),
            //DateTimeField::new('date')->onlyOnIndex(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle('index', '%entity_label_plural% 列表')
            ->overrideTemplate('crud/index', 'index1.html.twig')
        ;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            //->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
        ;
    }

    public function configureResponseParameters(KeyValueStore $responseParameters): KeyValueStore
    {
        if (Crud::PAGE_DETAIL === $responseParameters->get('pageName')) {
            $trainingId = $responseParameters->get('entity')->getInstance()->getId();
            $training = $this->getDoctrine()->getRepository(Training::class)->findOneByIdJoinedToTrainee($trainingId);
            if(is_null($training)){
                $trainees = null;
            }
            else{
                $trainees = $training->getTrainees();
                foreach($trainees as $v){
                    $v->setArea(Trainee::$areas[$v->getArea()]);
                }
            }
                $responseParameters->set('trainees', $trainees);
        }

        return $responseParameters;
    }
}

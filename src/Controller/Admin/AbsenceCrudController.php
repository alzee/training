<?php

namespace App\Controller\Admin;

use App\Entity\Absence;
use App\Entity\Trainee;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\KeyValueStore;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\EntityFilter;
use Doctrine\ORM\EntityManagerInterface;

class AbsenceCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Absence::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setDefaultSort(['leaveAt' => 'DESC'])
            ->overrideTemplate('crud/index', 'absence_index.html.twig')
            ->setSearchFields(null)
        ;
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
            ->disable(Action::NEW);
        ;
    }

    /*
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(EntityFilter::new('name'))
        ;
    }
     */

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        // 如果删除考勤，重置 checkinCount 为 1 。主要用来修正误刷
        $te = $this->getDoctrine()->getRepository(Trainee::class)->find($entityInstance->getName());
        $te->setCheckinCount(1);
        $entityManager->persist($te);

        $entityManager->remove($entityInstance);
        $entityManager->flush();
    }
}

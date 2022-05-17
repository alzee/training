<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Request;
use App\Entity\Trainee;
use App\Entity\Training;
use GatewayClient\Gateway;
use App\Controller\PushController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ArrayFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
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
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;

class TraineeCrudController extends AbstractCrudController
{
    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {
        $response = $this->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
        $response->andWhere('entity.isVisible = 1');
        return $response;
    }

    public static function getEntityFqcn(): string
    {
        return Trainee::class;
    }

    public function test()
    {
        $adminUrlGenerator = $this->get(AdminUrlGenerator::class);
        $url = $adminUrlGenerator->set('page', 2)->generateUrl();

    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            ImageField::new('image')->setUploadDir('public/images')->setBasePath('/images/avatar')->addCssClass('avatar')->hideOnForm(),
            //AvatarField::new('image'),
            TextField::new('name'),
            IntegerField::new('age'),
            ChoiceField::new('sex')->setChoices(array_flip(Trainee::$sexes))->renderExpanded(true),
            ChoiceField::new('pstatus')->setChoices(array_flip(Trainee::$pstatuses)),
            ChoiceField::new('politics')->setChoices(array_flip(Trainee::$allPolitics)),
            TextField::new('phone'),
            TextField::new('idnum')->hideOnIndex(),
            TextField::new('address'),
            ChoiceField::new('area')->setChoices(array_flip(Trainee::$areas)),
            TextField::new('level')->hideOnIndex(),
            ChoiceField::new('edu')->setChoices(array_flip(Trainee::$degrees)),
            TextField::new('company')->hideOnIndex(),
            TextField::new('company_property')->hideOnIndex(),
            TextField::new('service')->hideOnIndex(),
            TextField::new('pro_local')->hideOnIndex(),
            TextField::new('military_pro')->hideOnIndex(),
            TextField::new('hometown')->hideOnIndex(),
            ArrayField::new('skills')->hideOnIndex(),
            AssociationField::new('training'), //->hideOnForm(),
            // UrlField::new('gallery_link')->onlyOnDetail()->setValue('adsaf'),
            //ChoiceField::new('skills')->setChoices(Trainee::$allSkills)->allowMultipleChoices(true)->hideOnIndex(),
            //ArrayField::new('skills'),
            //CollectionField::new('skills'),
        ];
    }

    public function capture(Request $request)
    {
        Request::create('api/capture/1');
        // return $this->redirect($request->getUri());
    }

    public function configureActions(Actions $actions): Actions
    {
        $capture = Action::new('capture', 'capture', 'fa fa-user')
            ->linkToCrudAction('capture')
            ->displayAsButton()
            ->addCssClass('btn btn-success')
        ;
        return $actions
            // ->disable(Action::DELETE)
            ->add(Crud::PAGE_DETAIL, $capture)
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            //->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
        ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ChoiceFilter::new('area')->setChoices(array_flip(Trainee::$areas)))
            ->add('age')
            ->add(ChoiceFilter::new('pstatus')->setChoices(array_flip(Trainee::$pstatuses))) //->setFormTypeOption('comparison_type', 'ArrayFilter'))
            ->add(ChoiceFilter::new('politics')->setChoices(array_flip(Trainee::$allPolitics)))
            // ->add(ChoiceFilter::new('skills')->setChoices(Trainee::$allSkills))
            //->add(ChoiceFilter::new('skills')->setChoices($this->skills)->canSelectMultiple(true))
        ;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->overrideTemplate('crud/index', 'index0.html.twig')
            ->overrideTemplate('crud/new', 'new0.html.twig')
            ->overrideTemplate('crud/detail', 'detail0.html.twig')
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

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

class TraineeCrudController extends AbstractCrudController
{
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
            ChoiceField::new('sex')->setChoices(Trainee::$sexes)->renderExpanded(true),
            ChoiceField::new('pstatus')->setChoices(Trainee::$pstatuses),
            ChoiceField::new('politics')->setChoices(Trainee::$allPolitics),
            ChoiceField::new('area')->setChoices(array_flip(Trainee::$areas)),
            TextField::new('phone'),
            TextField::new('address'),
            TextField::new('idnum'),
            AssociationField::new('training'), //->hideOnForm(),
            ArrayField::new('skills')->hideOnIndex(),
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
            ->add(ChoiceFilter::new('pstatus')->setChoices(Trainee::$pstatuses)) //->setFormTypeOption('comparison_type', 'ArrayFilter'))
            ->add(ChoiceFilter::new('politics')->setChoices(Trainee::$allPolitics))
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

    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $entityManager->persist($entityInstance);
        $entityManager->flush();

        //$newId = $this->getDoctrine()->getRepository(Trainee::class)->findBy([], ["id" => "DESC"], 1)[0]->getId() + 1;
        $id = $entityInstance->getId();
        $entityInstance->setImage($id . '.jpg');
        $entityManager->persist($entityInstance);
        $entityManager->flush();

        $prefix = 'images/avatar/';
        copy($prefix . 'avatar.jpg', $prefix . $id . '.jpg');

        $data = [
            "cmd" => "addUser",
            //"cmd" => "onlineAuthorization",
            //"cmd" => "editUser",
            //"cmd" => "delUser",
            //"cmd" => "delMultiUserRet",
            //"cmd" => "delAllUser",
            "user_id" => $id,
            "name" => $entityInstance->getName(),
            "id_card" => $entityInstance->getIdnum(),
            "id_valid" => '',
            // 验证模式为人脸或卡时照片才不是非必填，但此模式下 Ic 必填
            "Ic" => '1001',
        ];
        $p = new PushController();
        $p->push($data);

    }

    public function deleteEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $data = [
            "cmd" => "delUser",
            "user_id" => $entityInstance->getId(),
            "user_type" => '0',
        ];
        $p = new PushController();
        $p->push($data);
        $entityManager->remove($entityInstance);
        $entityManager->flush();
    }

    public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        //$pic = readfile('images/avatar/' . $entityInstance->getId() . '.jpg');
        //dump($pic);
        //$base_pic = 'data:image/jpg;base64,' . base64_encode($pic);
        //$base_pic_urlencoded = urlencode($base_pic);
        $data = [
            "cmd" => "editUser",
            "user_id" => $entityInstance->getId(),
            "name" => $entityInstance->getName(),
            "id_card" => $entityInstance->getIdnum(),
            //"face_template" => 'http://192.168.0.55/images/avatar/' . $entityInstance->getId() . '.jpg',
            // "face_template" => $base_pic_urlencoded,
            "id_valid" => '',
            "Ic" => '1001',
            "edit_mode" => 1
        ];
        $p = new PushController();
        $p->push($data);
        $entityManager->persist($entityInstance);
        $entityManager->flush();
    }
}

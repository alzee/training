<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Entity\Trainee;
use App\Entity\Training;
use App\Entity\Checkin;
use App\Entity\Absence;
use App\Entity\C2;

class DashboardController extends AbstractDashboardController
{
    private $count = 55;

    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        //return parent::index();
        $trainees = $this->getDoctrine()->getRepository(Trainee::class)->findAll();
        $soldiers = $this->getDoctrine()->getRepository(Trainee::class)->findBy(['pstatus' => '1']);
        $partyMembers = $this->getDoctrine()->getRepository(Trainee::class)->findBy(['politics' => '1']);
        $faces = $this->getDoctrine()->getRepository(Trainee::class)->findBy(['face' => true]);
        $trainings = $this->getDoctrine()->getRepository(Training::class)->findAll();
        $checkins = $this->getDoctrine()->getRepository(Checkin::class)->findAll();
        $countTrainees = count($trainees);
        $countSoldiers = count($soldiers);
        $countPartyMembers = count($partyMembers);
        $countCheckins = count($trainees);

        $areas = Trainee::$areas;

        $countShouldCome = 0;
        $areaPeople = [];
        $agePeople = [];
        $ageGroup = [
            "18岁以下" => 0,
            "18-23" => 0,
            "24-29" => 0,
            "30-36" => 0,
            "37-45" => 0,
            "46岁以上" => 0
            ];
        $degreeGroup = [0, 0, 0, 0];
        foreach($trainees as $v){
            $countShouldCome += count($v->getTraining());

            if(isset($areas[$v->getArea()])){
                if(!isset($areaPeople[$areas[$v->getArea()]])){
                    $areaPeople[$areas[$v->getArea()]] = 0;
                }
                $areaPeople[$areas[$v->getArea()]] += 1;
            }

            $age = date("Y") - substr($v->getIdnum(), 6, 4);

            if($age < 18){
                $ageGroup["18岁以下"] += 1;
            }
            else if($age < 24){
                $ageGroup["18-23"] += 1;
            }
            else if($age < 30){
                $ageGroup["24-29"] += 1;
            }
            else if($age < 37){
                $ageGroup["30-36"] += 1;
            }
            else if($age < 46){
                $ageGroup["37-45"] += 1;
            }
            else{
                $ageGroup["46岁以上"] += 1;
            }

            $degreeGroup[$v->getEdu()] += 1;
        }

        $data = [
            "countTrainees" => $countTrainees,
            "countFaces" => count($faces),
            "countTrainings" => count($trainings),
            "countCheckins" => count($checkins),
            "countSoldiers" => $countSoldiers,
            "countPartyMembers" => $countPartyMembers,
            "countCheckins" => $countCheckins,
            "countShouldCome" => $countShouldCome,
            "areaPeople" => $areaPeople,
            "ageGroup" => $ageGroup,
            "degreeGroup" => $degreeGroup,
        ];
        return $this->render('dashboard.html.twig', $data);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('民兵军事训练信息化管理系统')
            ->setTranslationDomain('admin')
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('综合统计', 'fa fa-chart-pie');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
        
        yield MenuItem::linkToCrud('个人信息', 'fa fa-user', Trainee::class);

        yield MenuItem::linkToCrud('训练记录', 'fa fa-running', Training::class)->setAction('new');
        yield MenuItem::linkToCrud('训练档案', 'fa fa-file-alt', Training::class);

        //yield MenuItem::subMenu('训练管理', 'fa fa-tags')->setSubItems([
        //    MenuItem::linkToCrud('添加训练', '', Training::class)->setAction('new'),
        //    MenuItem::linkToCrud('训练列表', '', Training::class),
        //]);

        //yield MenuItem::linkToCrud('签到记录', 'fa fa-tags', Checkin::class);
        yield MenuItem::linkToCrud('考勤记录', 'fa fa-clock', Absence::class);
        // yield MenuItem::linkToCrud('签到记录', 'fa fa-tags', C2::class);

        //yield MenuItem::linkToLogout('Logout', 'fa fa-exit');
        yield MenuItem::linkToCrud('电子档案', 'fa fa-images', Trainee::class)->setController(GalleryCrudController::class);
    }

    public function configureCrud(): Crud
    {
        return Crud::new()
            // this defines the pagination size for all CRUD controllers
            // (each CRUD controller can override this value if needed)
            ->setPaginatorPageSize(30)
        ;
    }

    public function configureActions(): Actions
    {
        return Actions::new()
            ->add(Crud::PAGE_INDEX, Action::NEW)
            ->add(Crud::PAGE_INDEX, Action::EDIT)
            ->add(Crud::PAGE_INDEX, Action::DELETE)
            ->add(Crud::PAGE_DETAIL, Action::EDIT)
            ->add(Crud::PAGE_DETAIL, Action::INDEX)
            ->add(Crud::PAGE_DETAIL, Action::DELETE)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_RETURN)
            ->add(Crud::PAGE_NEW, Action::SAVE_AND_RETURN)
        ;
    }
}

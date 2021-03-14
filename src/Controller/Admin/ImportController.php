<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Trainee;
use App\Entity\Training;
use App\Entity\Checkin;
use App\Entity\C2;

class ImportController extends AbstractDashboardController
{
    /**
     * @Route("/import", name="import")
     */
    public function index(): Response
    {
        //return parent::index();
        return $this->render('import.html.twig');
    }
}

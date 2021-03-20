<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Controller\Admin\DashboardController;

class EduController extends DashboardController
{
    /**
     * @Route("/edu", name="edu")
     */
    public function index(): Response
    {
        //return $this->render('edu.html.twig');
        return parent::index();
    }
}

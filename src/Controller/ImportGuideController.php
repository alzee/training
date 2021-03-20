<?php

namespace App\Controller;

use App\Controller\Admin\DashboardController;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ImportGuideController extends DashboardController
{
    /**
     * @Route("/import/guide", name="import_guide")
     */
    public function guide(): Response
    {
        return $this->render('import_guide/index.html.twig', [
            'controller_name' => 'ImportGuideController',
        ]);
    }
}

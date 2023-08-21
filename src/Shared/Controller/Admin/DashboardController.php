<?php

namespace App\Shared\Controller\Admin;

use App\Sensor\Domain\Entity\Sensor;
use App\Sensor\Infrastructure\Controller\Admin\SensorCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
         return $this->render('admin/admin-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Multipass Homework');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

        yield MenuItem::section('Sensors');
        yield MenuItem::linkToCrud('Sensor', 'fas fa-list', Sensor::class);

        yield MenuItem::section('Temperature reading');
    }
}

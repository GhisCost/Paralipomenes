<?php

namespace App\Controller\Admin;


use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\MessagesCrudController;


#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class DashboardController extends AbstractDashboardController
{
    public function index(): Response
    {
        
        return $this->redirectToRoute('admin_histoires_index');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Paralipomenes');
    }

    public function configureMenuItems(): iterable
{
    return [
        MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),

        MenuItem::section('Contenu'),
        MenuItem::linkTo(HistoiresCrudController::class, 'Histoires', 'fas fa-align-justify'),
        MenuItem::linkTo(ChapitresCrudController::class, 'Chapitres', 'fas fa-align-justify'),
        MenuItem::linkTo(MessagesCrudController::class, 'Messages', 'fas fa-envelope'),
        MenuItem::linkTo(CorrectionsCrudController::class, 'Corrections', 'fas fa-edit'),
        MenuItem::linkTo(PieceJointeCrudController::class, 'Pièces jointes', 'fas fa-paperclip'),

        MenuItem::section('Utilisateurs'),
        MenuItem::linkTo(UserCrudController::class, 'Utilisateurs', 'fas fa-user'),

        MenuItem::section('Site'),
        MenuItem::linkToUrl('Retour au site', 'fa fa-globe', '/'),
    ];
}
}
<?php

namespace App\Controller\Admin;

use App\Entity\Invitation;
use App\Entity\Media;
use App\Entity\Picture;
use App\Entity\User;
use App\Entity\UserPicture;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //        return parent::index();
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        return $this->redirect($adminUrlGenerator->setController(PictureCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Wonders From Stars');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Images', 'fa fa-image', Picture::class);
        yield MenuItem::linkToCrud('Invitation', 'fa fa-envelope', Invitation::class);
        yield MenuItem::linkToCrud('Medias', 'fa fa-image', Media::class);
        yield MenuItem::linkToCrud('User', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('UserPicture', 'fa fa-user', UserPicture::class);
        yield MenuItem::linkToLogout('Logout', 'fa fa-door-open');
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\BlogPost;
use App\Entity\Doleance;
use App\Form\DoleanceType;
use App\Entity\CategoryPost;
use App\Entity\Comment;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('DefMada');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Doléances', 'fas fa-list',Doleance::class);
        yield MenuItem::linkToCrud('Blog', 'fas fa-list',BlogPost::class);
        yield MenuItem::linkToCrud('Categorie article', 'fas fa-list',CategoryPost::class);
        yield MenuItem::linkToCrud('Commentaires', 'fas fa-list',Comment::class);
    }
}

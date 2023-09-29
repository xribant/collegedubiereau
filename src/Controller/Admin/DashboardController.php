<?php

namespace App\Controller\Admin;

use App\Entity\MainMenu;
use App\Entity\Page;
use App\Entity\Article;
use App\Entity\Bullet;
use App\Entity\BulletList;
use App\Entity\Fonction;
use App\Entity\Member;
use App\Entity\Section;
use App\Entity\News;
use App\Entity\User;
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
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);

        $url = $adminUrlGenerator
            ->setController(UserCrudController::class)
            ->generateUrl();

        return $this->redirect($url);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<img src="assets/admin/img/logo-dashboard.png" alt="College du biéreau admin"');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-dashboard');
        yield MenuItem::section('Configuration');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-user', User::class);
        yield MenuItem::section('Contenu');
        yield MenuItem::linkToCrud('Communications', 'fa-solid fa-radio', News::class);
        yield MenuItem::linkToCrud('Menus', 'fa-solid fa-sitemap', MainMenu::class);
        yield MenuItem::linkToCrud('Pages', 'fa-solid fa-file-lines', Page::class);
        yield MenuItem::linkToCrud('Articles', 'fa-solid fa-newspaper', Article::class);
        yield MenuItem::linkToCrud('Listes', 'fa-solid fa-radio', BulletList::class);
        yield MenuItem::linkToCrud('Elements de liste', 'fa-solid fa-list-ul', Bullet::class);
        yield MenuItem::section('Equipe');
        yield MenuItem::linkToCrud('Sections', 'fa-solid fa-people-group', Section::class);
        yield MenuItem::linkToCrud('Fonctions', 'fa-solid fa-briefcase', Fonction::class);
        yield MenuItem::linkToCrud('Membres', 'fa-solid fa-user', Member::class);
    }
}

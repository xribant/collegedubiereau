<?php

namespace App\Controller;

use App\Repository\PageRepository;
use App\Repository\SectionGroupRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontPageController extends AbstractController
{
   
    #[Route('/{menu_slug}/equipe-educative', name: 'app_front_team')]
    public function indexTeamPage(SectionGroupRepository $sectionGroupRepository, PageRepository $pageRepository): Response
    {
        $page = $pageRepository->findOneBy(['slug' => 'equipe-educative']);
        $departements = $sectionGroupRepository->findByPosition();

        return $this->render('front_page/index.html.twig', [
            'page' => $page,
            'departements' => $departements
        ]);
    }

    #[Route('/{page_slug}', name: 'app_front_mainpage', priority: -1)]
    public function indexMainPage(PageRepository $pageRepository, $page_slug): Response
    {
        $page = $pageRepository->findOneBy(['slug' => $page_slug]);

        return $this->render('front_page/index.html.twig', [
            'page' => $page,
        ]);
    }

    #[Route('/{menu_slug}/{page_slug}', name: 'app_front_subpage', priority: -1)]
    public function indexSubPage(PageRepository $pageRepository, $page_slug): Response
    {
        $page = $pageRepository->findOneBy(['slug' => $page_slug]);

        return $this->render('front_page/index.html.twig', [
            'page' => $page,
        ]);
    }
}

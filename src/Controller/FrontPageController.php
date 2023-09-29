<?php

namespace App\Controller;

use App\Repository\MemberRepository;
use App\Repository\PageRepository;
use App\Repository\SectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FrontPageController extends AbstractController
{
    #[Route('/{page_slug}', name: 'app_front_mainpage', priority: -1)]
    public function indexMainPage(SectionRepository $sectionRepository, PageRepository $pageRepository, $page_slug): Response
    {
        $page = $pageRepository->findOneBy(['slug' => $page_slug]);
        $sections = $sectionRepository->findAll();

        return $this->render('front_page/index.html.twig', [
            'page' => $page,
            'sections' => $sections
        ]);
    }

    #[Route('/{menu_slug}/{page_slug}', name: 'app_front_subpage', priority: -1)]
    public function indexSubPage(SectionRepository $sectionRepository, PageRepository $pageRepository, $page_slug): Response
    {
        $page = $pageRepository->findOneBy(['slug' => $page_slug]);
        $sections = $sectionRepository->findAll();

        return $this->render('front_page/index.html.twig', [
            'page' => $page,
            'sections' => $sections
        ]);
    }
}

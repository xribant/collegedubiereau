<?php

namespace App\Controller;

use App\Repository\NewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home', options: ['sitemap' => true])]
    public function index(NewsRepository $newsRepository): Response
    {
        $news = $newsRepository->findAllPublished();
        $communications = [];

        foreach($news as $item){
            $communications[] = $item->getText();
        }

        return $this->render('home/index.html.twig', [
            'news' => $communications
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InfosPratiquesController extends AbstractController
{
    #[Route('/infos/pratiques', name: 'app_infos_pratiques')]
    public function index(): Response
    {
        return $this->render('infos_pratiques/index.html.twig', [
            'controller_name' => 'InfosPratiquesController',
        ]);
    }
}

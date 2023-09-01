<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProjetPedagogiqueController extends AbstractController
{
    #[Route('/projet/pedagogique', name: 'app_projet_pedagogique')]
    public function index(): Response
    {
        return $this->render('projet_pedagogique/index.html.twig', [
            'controller_name' => 'ProjetPedagogiqueController',
        ]);
    }
}

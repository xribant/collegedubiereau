<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LEcoleController extends AbstractController
{
    #[Route('/ecole/presentation', name: 'app_ecole_presentation')]
    public function presentation(): Response
    {
        return $this->render('l_ecole/presentation.html.twig');
    }

    #[Route('/ecole/projet-educatif-et-pedagogique', name: 'app_ecole_presentation')]
    public function projet_educatif(): Response
    {
        return $this->render('l_ecole/projet_educatif.html.twig');
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ParrainController extends AbstractController
{
    #[Route('/parrain', name: 'app_parrain')]
    public function index(): Response
    {
        return $this->render('parrain/index.html.twig', [
            'controller_name' => 'ParrainController',
        ]);
    }
}

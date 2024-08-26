<?php

namespace App\Controller;

use App\Repository\DirectionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DirectionController extends AbstractController
{
    #[Route('/direction', name: 'app_direction')]
    public function index(DirectionRepository $directionRepository): Response
    {
        $directions = $directionRepository->findAll();
        return $this->render('direction/index.html.twig', [
            'controller_name' => 'DirectionController',
            'directions' => $directions,
        ]);
    }
}

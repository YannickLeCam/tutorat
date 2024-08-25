<?php

namespace App\Controller;

use App\Entity\Filleul;
use App\Repository\FilleulRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class FilleulController extends AbstractController
{
    #[Route('/filleul', name: 'app_filleul')]
    public function index(FilleulRepository $filleulRepository): Response
    {
        $filleuls = $filleulRepository->findAll();
        return $this->render('filleul/index.html.twig', [
            'controller_name' => 'FilleulController',
            'filleuls'=>$filleuls,
        ]);
    }

    #[Route('/filleul/show-{id}', name: 'app_filleul.show')]
    public function show(Filleul $filleul):Response{
        return $this->render('filleul/show.html.twig', [
            'controller_name' => 'FilleulController',
            'filleul'=>$filleul,
        ]);
    }
}

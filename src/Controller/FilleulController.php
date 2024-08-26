<?php

namespace App\Controller;

use App\Entity\Filleul;
use App\Form\NouvFilleulType;
use App\Repository\FilleulRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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

    #[Route('/filleul/new',name:'app_filleul.new')]
    #[Route('/filleul/edit-{id}',name:'app_filleul.edit')]
    public function new(Filleul $filleul=null,Request $request,EntityManagerInterface $em):Response
    {
        //Faire une verification que l'utilisateur est bien un Admin ou un membre de la direction
        if (!$filleul) {
            $filleul = new Filleul();
        }
        $form = $this->createForm(NouvFilleulType::class , $filleul);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid() ) {
            $newFilleul= $form->getData();
            $em->persist($newFilleul);
            $em->flush();
            $this->addFlash('success','Vous avez bien ajouté un nouveau filleul !');
            return $this->redirectToRoute('app_home');
        }else {
            $this->addFlash('error','Il semble avoir eu une erreur lors de l\'ajout du filleul');
        }

        return $this->render('filleul/new.html.twig', [
            'controller_name' => 'FilleulController',
            'form'=> $form,
        ]);
    }
}

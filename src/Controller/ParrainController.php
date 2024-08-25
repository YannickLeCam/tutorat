<?php

namespace App\Controller;

use App\Form\RapportParrainType;
use App\Entity\ParrainAppreciation;
use App\Repository\FilleulRepository;
use App\Repository\ParrainRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ParrainController extends AbstractController
{
    #[Route('/parrain', name: 'app_parrain')]
    public function index(): Response
    {
        return $this->render('parrain/index.html.twig', [
            'controller_name' => 'ParrainController',
        ]);
    }

    // #[Route('/appreciation/{idParrain}-{idFilleul}', name: 'app_parrain.appreciation')]
    // public function ajoutAppreciation(Request $request,ParrainAppreciation $parrainAppreciation=null,int $idParrain , int $idFilleul, ParrainRepository $parrainAppreciation , FilleulRepository $filleulRepository,EntityManagerInterface $entityManager): Response
    // {
    //     if ($parrainAppreciation===null) {
    //         $parrainAppreciation = new ParrainAppreciation();
    //     }

    //     $form = $this->createForm(RapportParrainType::class,$parrainAppreciation);

    //     return $this->render('parrain/index.html.twig', [
    //         'controller_name' => 'ParrainController',
    //     ]);
    // }
    #[Route('/appreciation/new/{idParrain}-{idFilleul}', name: 'appreciation.new')]
    #[Route('/appreciation/edit-{id}', name: 'appreciation.edit',requirements : ['id'=>'\d+'])]
    public function new(ParrainAppreciation $appreciation = null,int $idParrain,int $idFilleul,Request $request,EntityManagerInterface $em,ParrainRepository $parrainRepository,FilleulRepository $filleulRepository): Response
    {
        if (!$appreciation) {
            $appreciation = new ParrainAppreciation();
            $parrain = $parrainRepository->findOneBy(['id'=>$idParrain]);
            $appreciation->setParrain($parrain);
            $filleul = $filleulRepository->findOneBy(['id'=>$idFilleul]);
            $appreciation->setFilleul($filleul);
            $appreciation->setDateCreation(new DateTime());
        }
        $form = $this->createForm(RapportParrainType::class , $appreciation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid() ) {
            $newAppreciation= $form->getData();
            $em->persist($newAppreciation);
            $em->flush();
            $this->addFlash('success','Vous avez bien ajouté un nouveau stagiaire !');
            return $this->redirectToRoute('app_home ');
        }

        return $this->render('parrain/appreciation.html.twig', [
            'controller_name' => 'Appreciation',
            'form'=>$form,
        ]);
    }

}

<?php

namespace App\Controller;

use DateTime;
use App\Entity\Parrain;
use App\Form\NouvParrainType;
use App\Form\RapportParrainType;
use App\Form\RechercheParrainType;
use App\Entity\ParrainAppreciation;
use App\Repository\FilleulRepository;
use App\Repository\ParrainRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ParrainController extends AbstractController
{
    #[Route('/parrain/show-{id}',name:'app_parrain.show')]
    public function show(Parrain $parrain):Response
    {
        return $this->render('parrain/show.html.twig', [
            'controller_name' => 'ParrainController',
            'parrain' => $parrain,
        ]);
    }

    #[Route('/parrain/new', name: 'app_parrain.new')]
    #[Route('/parrain/edit-{id}', name: 'app_parrain.edit')]
    public function new(Parrain $parrain = null, Request $request, EntityManagerInterface $em): Response
    {
        // Faire une vérification que l'utilisateur est bien un Admin ou un membre de la direction
        if (!$parrain) {
            $parrain = new Parrain();
        }

        $form = $this->createForm(NouvParrainType::class, $parrain);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newParrain = $form->getData();
            $em->persist($newParrain);
            $em->flush();
            $this->addFlash('success', 'Vous avez bien ajouté un nouveau parrain !');
            return $this->redirectToRoute('app_home');
        } else {
            $this->addFlash('error', 'Il semble y avoir eu une erreur lors de l\'ajout du parrain');
        }

        return $this->render('parrain/new.html.twig', [
            'controller_name' => 'ParrainController',
            'form' => $form,
        ]);
    }

    #[Route('/appreciation/new/{idParrain}-{idFilleul}', name: 'appreciation.new')]
    public function newAppreciation(ParrainAppreciation $appreciation = null,int $idParrain,int $idFilleul,Request $request,EntityManagerInterface $em,ParrainRepository $parrainRepository,FilleulRepository $filleulRepository): Response
    {
         // Vérifier si l'utilisateur est connecté
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_login');
        }

        if ($appreciation === null) {

            // Vérifier que les entités avec les IDs fournis existent bien
            $parrain = $parrainRepository->find($idParrain);
            $filleul = $filleulRepository->find($idFilleul);

            if (!$parrain || !$filleul) {
                throw $this->createNotFoundException('Parrain ou Filleul non trouvé.');
            }
            // Vérifier que l'utilisateur connecté est bien le parrain associé au filleul
            
            if ($filleul->getParrain()->getId() !== $idParrain) {
                throw $this->createAccessDeniedException('Vous n\'êtes pas autorisé à mettre une appréciation.');
            }
            $appreciation = new ParrainAppreciation();
            $appreciation->setParrain($parrain);
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
            return $this->redirectToRoute('app_home');
        }

        return $this->render('parrain/appreciation.html.twig', [
            'controller_name' => 'Appreciation',
            'form'=>$form,
        ]);
    }
    #[Route('/appreciation/edit-{id}', name: 'appreciation.edit',requirements : ['id'=>'\d+'])]
    public function editAppreciation(ParrainAppreciation $appreciation = null,Request $request,EntityManagerInterface $em,ParrainRepository $parrainRepository,FilleulRepository $filleulRepository): Response
    {
         // Vérifier si l'utilisateur est connecté
        if (!$this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('app_login');
        }
        
        $form = $this->createForm(RapportParrainType::class , $appreciation);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid() ) {
            $newAppreciation= $form->getData();
            $em->persist($newAppreciation);
            $em->flush();
            $this->addFlash('success','Vous avez bien ajouté un nouveau stagiaire !');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('parrain/appreciation.html.twig', [
            'controller_name' => 'Appreciation',
            'form'=>$form,
        ]);
    }

    #[Route('/parrain', name: 'app_parrain')]
    public function index(Request $request, ParrainRepository $parrainRepository): Response
    {
        // Créer le formulaire de recherche
        $formRecherche = $this->createForm(RechercheParrainType::class, new Parrain());
        $formRecherche->handleRequest($request);

        $criteria = [];
        if ($formRecherche->isSubmitted() && $formRecherche->isValid()) {
            // Récupérer les données du formulaire
            $data = $formRecherche->getData();

            // Ajouter les critères en fonction des champs remplis
            if ($data->getNom()) {
                $criteria['nom'] = $data->getNom();
            }

            if ($data->getPrenom()) {
                $criteria['prenom'] = $data->getPrenom();
            }

            if ($data->getTop()) {
                $criteria['top'] = $data->getTop();
            }

            if ($data->getFaculte()) {
                $criteria['faculte'] = $data->getFaculte();
            }
        }

        // Utiliser findBy avec les critères
        $parrains = $parrainRepository->searchParrains($criteria);

        return $this->render('parrain/index.html.twig', [
            'controller_name' => 'ParrainController',
            'parrains' => $parrains,
            'formRecherche' => $formRecherche->createView(),
        ]);
    }

}

<?php

namespace App\Controller;

use DateTime;
use App\Entity\Top;
use App\Form\NouvTopType;
use App\Form\RapportTopType;
use App\Entity\TopAppreciation;
use App\Form\RechercheTopType;
use App\Repository\FilleulRepository;
use App\Repository\TopRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TopController extends AbstractController
{
    #[Route('/top/show-{id}',name:'app_top.show')]
    public function show(Top $top):Response
    {
        return $this->render('top/show.html.twig', [
            'controller_name' => 'TopController',
            'top' => $top,
        ]);
    }

    #[Route('/top/new', name: 'app_top.new')]
    #[Route('/top/edit-{id}', name: 'app_top.edit')]
    public function new(Top $top = null, Request $request, EntityManagerInterface $em): Response
    {
        // Faire une vérification que l'utilisateur est bien un Admin ou un membre de la direction
        if (!$top) {
            $top = new Top();
        }

        $form = $this->createForm(NouvTopType::class, $top);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newTop = $form->getData();
            $em->persist($newTop);
            $em->flush();
            $this->addFlash('success', 'Vous avez bien ajouté un nouveau Top !');
            return $this->redirectToRoute('app_home');
        } else {
            $this->addFlash('error', 'Il semble y avoir eu une erreur lors de l\'ajout du Top');
        }

        return $this->render('top/new.html.twig', [
            'controller_name' => 'TopController',
            'form' => $form,
        ]);
    }


    #[Route('/top', name: 'app_top')]
    public function index(Request $request, TopRepository $topRepository): Response
    {
        // Créer le formulaire de recherche
        $formRecherche = $this->createForm(RechercheTopType::class, new Top());
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

            if ($data->getFaculte()) {
                $criteria['faculte'] = $data->getFaculte();
            }
        }

        // Utiliser findBy avec les critères
        $tops = $topRepository->searchTops($criteria);

        return $this->render('top/index.html.twig', [
            'controller_name' => 'TopController',
            'tops' => $tops,
            'formRecherche' => $formRecherche->createView(),
        ]);
    }
}
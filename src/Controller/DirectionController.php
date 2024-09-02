<?php

namespace App\Controller;

use DateTime;
use App\Entity\Mineure;
use App\Entity\Direction;
use App\Entity\Specialite;
use App\Form\NouvMineurType;
use App\Form\NouvDirectionType;
use App\Form\NouvSpecialiteType;
use App\Form\RapportDirectionType;
use App\Form\RechercheDirectionType;
use App\Entity\DirectionAppreciation;
use App\Repository\FilleulRepository;
use App\Repository\MineureRepository;
use App\Repository\DirectionRepository;
use App\Repository\SpecialiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DirectionController extends AbstractController
{
    #[Route('/direction/show-{id}',name:'app_direction.show')]
    public function show(Direction $direction): Response
    {
        return $this->render('direction/show.html.twig', [
            'controller_name' => 'DirectionController',
            'direction' => $direction,
        ]);
    }

    #[Route('/direction/new', name: 'app_direction.new')]
    #[Route('/direction/edit-{id}', name: 'app_direction.edit')]
    public function new(Direction $direction = null, Request $request, EntityManagerInterface $em): Response
    {
        // Verify that the user is an Admin or a member of the management team
        if (!$direction) {
            $direction = new Direction();
        }

        $form = $this->createForm(NouvDirectionType::class, $direction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newDirection = $form->getData();
            $em->persist($newDirection);
            $em->flush();
            $this->addFlash('success', 'You have successfully added a new direction!');
            return $this->redirectToRoute('app_home');
        } else {
            $this->addFlash('error', 'An error occurred while adding the direction.');
        }

        return $this->render('direction/new.html.twig', [
            'controller_name' => 'DirectionController',
            'form' => $form,
        ]);
    }

    #[Route('/direction/mineure/new', name: 'app_mineur.new')]
    #[Route('/direction/mineure/edit-{id}', name: 'app_mineur.edit')]
    public function newMineur(Mineure $mineure = null, Request $request, EntityManagerInterface $em): Response
    {
        // Verify that the user is an Admin or a member of the management team
        if (!$mineure) {
            $mineure = new Mineure();
        }

        $form = $this->createForm(NouvMineurType::class, $mineure);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newMineure = $form->getData();
            $em->persist($newMineure);
            $em->flush();
            $this->addFlash('success', 'You have successfully added a new direction!');
            return $this->redirectToRoute('app_mineur');
        } else {
            $this->addFlash('error', 'An error occurred while adding the direction.');
        }

        return $this->render('direction/mineurAdd.html.twig', [
            'controller_name' => 'OtherController',
            'form' => $form,
        ]);
    }

    #[Route('/direction/mineure', name: 'app_mineur')]
    public function listMineur(MineureRepository $mineureRepository): Response
    {
        $mineures = $mineureRepository->findAll();
        return $this->render('direction/mineurList.html.twig', [
            'controller_name' => 'OtherController',
            'mineures' => $mineures,
        ]);
    }

    #[Route('/direction/mineure/delete-{id}', name: 'app_mineur.del')]
    public function deleteMineur(Mineure $mineure,EntityManagerInterface $em): Response
    {
        $em->remove($mineure);
        $em->flush();
        $this->addFlash('sucess','Vous avez bien supprimé la mineur !');

        return $this->redirectToRoute('app_mienur');
    }

    #[Route('/direction/specialite/new', name: 'app_specialite.new')]
    #[Route('/direction/specialite/edit-{id}', name: 'app_specialite.edit')]
    public function newSpecialite(Specialite $specialite = null, Request $request, EntityManagerInterface $em): Response
    {
        // Verify that the user is an Admin or a member of the management team
        if (!$specialite) {
            $specialite = new Specialite();
        }

        $form = $this->createForm(NouvSpecialiteType::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newSpecialite = $form->getData();
            $em->persist($newSpecialite);
            $em->flush();
            $this->addFlash('success', 'You have successfully added a new direction!');
            return $this->redirectToRoute('app_mineur');
        } else {
            $this->addFlash('error', 'An error occurred while adding the direction.');
        }

        return $this->render('direction/specialiteAdd.html.twig', [
            'controller_name' => 'OtherController',
            'form' => $form,
        ]);
    }

    #[Route('/direction/specialite', name: 'app_specialite')]
    public function listSpecialite(SpecialiteRepository $specialiteRepository): Response
    {
        $specialites = $specialiteRepository->findAll();
        return $this->render('direction/specialiteList.html.twig', [
            'controller_name' => 'OtherController',
            'specialites' => $specialites,
        ]);
    }

    #[Route('/direction/specialite/delete-{id}', name: 'app_specialite.del')]
    public function deleteSpecialite(Specialite $specialite,EntityManagerInterface $em): Response
    {
        $em->remove($specialite);
        $em->flush();
        $this->addFlash('sucess','Vous avez bien supprimé la spécialité !');

        return $this->redirectToRoute('app_speciallite');
    }

    #[Route('/direction', name: 'app_direction')]
    public function index(Request $request, DirectionRepository $directionRepository): Response
    {
        // Create the search form
        $formRecherche = $this->createForm(RechercheDirectionType::class, new Direction());
        $formRecherche->handleRequest($request);

        $criteria = [];
        if ($formRecherche->isSubmitted() && $formRecherche->isValid()) {
            // Retrieve form data
            $data = $formRecherche->getData();

            // Add criteria based on filled fields
            if ($data->getName()) {
                $criteria['name'] = $data->getName();
            }

            if ($data->getDepartment()) {
                $criteria['department'] = $data->getDepartment();
            }

            if ($data->getTop()) {
                $criteria['top'] = $data->getTop();
            }

            if ($data->getFaculty()) {
                $criteria['faculty'] = $data->getFaculty();
            }
        }

        // Use findBy with the criteria
        $directions = $directionRepository->searchDirections($criteria);

        return $this->render('direction/index.html.twig', [
            'controller_name' => 'DirectionController',
            'directions' => $directions,
            'formRecherche' => $formRecherche->createView(),
        ]);
    }
}

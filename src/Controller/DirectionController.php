<?php

namespace App\Controller;

use DateTime;
use App\Entity\Mineure;
use App\Entity\Direction;
use App\Form\NouvMineurType;
use App\Form\NouvDirectionType;
use App\Form\RapportDirectionType;
use App\Form\RechercheDirectionType;
use App\Entity\DirectionAppreciation;
use App\Repository\FilleulRepository;
use App\Repository\MineureRepository;
use App\Repository\DirectionRepository;
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

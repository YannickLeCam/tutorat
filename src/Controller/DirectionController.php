<?php

namespace App\Controller;

use DateTime;
use App\Entity\Filleul;
use App\Entity\Mineure;
use App\Entity\Parrain;
use App\Entity\Direction;
use App\Entity\Specialite;
use App\Form\NouvMineurType;
use App\Form\NouvDirectionType;
use Doctrine\ORM\EntityManager;
use App\Form\NouvSpecialiteType;
use App\Form\RapportDirectionType;
use App\Form\RechercheParrainType;
use App\Form\FilleulAssignmentType;
use App\Form\RechercheDirectionType;
use App\Entity\DirectionAppreciation;
use App\Repository\FilleulRepository;
use App\Repository\MineureRepository;
use App\Repository\ParrainRepository;
use App\Repository\DirectionRepository;
use App\Repository\SpecialiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;

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

    #[Route('/direction/delete-{id}', name: 'app_direction.del')]
    public function delete(Direction $direction,EntityManagerInterface $em): Response
    {
        $em->remove($direction);
        $em->flush();
        $this->addFlash('sucess','Vous avez bien supprimé le membre de la direction !');

        return $this->redirectToRoute('app_direction');
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

// src/Controller/DirectionController.php

// ... le reste du code

#[Route('/direction/mineure/delete/{id}', name: 'app_mineur.del', methods: ['GET', 'POST'])]
public function deleteMineur(
    Request $request,
    Mineure $mineure,
    EntityManagerInterface $entityManager
): Response {
    
    try {
        $entityManager->remove($mineure);
        $entityManager->flush();

        $this->addFlash('success', 'Mineure supprimée avec succès.');
        return $this->redirectToRoute('app_mineure');
    } catch (\Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException $e) {
        $filleuls = $mineure->getFilleuls();
        $mineures = $entityManager->getRepository(Mineure::class)->findAll();

        // Exclure la mineure actuelle de la liste des mineures disponibles
        $mineuresDisponibles = array_filter($mineures, fn($m) => $m->getId() !== $mineure->getId());

        // Créer un formulaire pour chaque filleul
        $forms = [];
        foreach ($filleuls as $filleul) {
            $form = $this->createForm(FilleulAssignmentType::class, null, [
                'mineures_disponibles' => $mineuresDisponibles,
            ]);
            $form->handleRequest($request);
            $forms[$filleul->getId()] = $form->createView(); // Utilisez createView()
        }

        // Traiter les soumissions du formulaire
        $formData = [];
        foreach ($forms as $filleulId => $formView) {
            if ($request->request->get("form_{$filleulId}_submit")) {
                $form = $this->createForm(FilleulAssignmentType::class, null, [
                    'mineures_disponibles' => $mineuresDisponibles,
                ]);
                $form->handleRequest($request);
                if ($form->isSubmitted() && $form->isValid()) {
                    $formData[$filleulId] = $form->getData();
                }
            }
        }

        if (!empty($formData)) {
            foreach ($formData as $filleulId => $data) {
                $filleul = $entityManager->getRepository(Filleul::class)->find($filleulId);
                $nouvelleMineure = $data['nouvelle_mineure'];
                $filleul->setMineure($nouvelleMineure);
                $entityManager->persist($filleul);
            }
            $entityManager->flush();

            $this->addFlash('success', 'Filleuls réassignés avec succès.');
            return $this->redirectToRoute('app_mineur');
        }

        return $this->render('direction/mineurDeleteError.html.twig', [
            'controller_name' => 'OtherController',
            'mineure' => $mineure,
            'forms' => $forms,
        ]);
    }
}


    #[Route('/direction/mineure/reassign', name: 'app_mineur.reassign', methods: ['POST'])]
    public function reassignFilleuls(Request $request, EntityManagerInterface $entityManager): Response
    {
        // Récupérer toutes les données envoyées
        $data = $request->request->all();
    
        // Initialiser un tableau pour stocker les ids des filleuls à réaffecter
        $filleulAssignments = [];
    
        // Traiter les données pour extraire les id des filleuls et leur nouvelle mineure
        foreach ($data as $key => $value) {
            if (is_numeric($key)) {
                // Récupérer l'id du filleul et la mineure à laquelle il doit être réaffecté
                $filleulId = $key;
                $newMineureId = $value['filleul'] ?? null;
    
                if ($newMineureId) {
                    $filleulAssignments[$filleulId] = $newMineureId;
                }
            }
        }
    
        // Traiter les réaffectations
        foreach ($filleulAssignments as $filleulId => $newMineureId) {
            $filleul = $entityManager->getRepository(Filleul::class)->find($filleulId);
            $newMineure = $entityManager->getRepository(Mineure::class)->find($newMineureId);
    
            if ($filleul && $newMineure) {
                $filleul->setMineure($newMineure);
                $entityManager->persist($filleul);
            }
        }
    
        $entityManager->flush();
    
        $this->addFlash('success', 'Réassignation des filleuls réussie.');
        return $this->redirectToRoute('app_mineur');
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

    #[Route('/direction/compta', name: 'app_compta')]
    public function compta(Request $request,ParrainRepository $parrainRepository): Response
    {
        $user = $this->getUser();   
        if ($user) {
            $role = $user->getRoles();
            if ($role[0] !== 'ROLE_ADMIN' && $role[0] !== 'ROLE_DIRECTION') {
                $this->addFlash('error', 'Vous n\'avez pas accès a cette page . . .');
                return $this->redirectToRoute('app_home'); // Redirige vers la page d'accueil ou une autre page appropriée
            }
            
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
        }else {
            $this->addFlash('error', 'Vous devez être connecté pour accéder a cette page . . .');
            return $this->redirectToRoute('app_login'); // Redirige vers la page d'accueil ou une autre page appropriée
        }
        

        return $this->render('direction/compta.html.twig', [
            'controller_name' => 'OtherController',
            'parrains'=>$parrains,
            'formRecherche' => $formRecherche->createView(),
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

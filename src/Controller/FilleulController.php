<?php

namespace App\Controller;

use App\Entity\Filleul;
use App\Form\NouvFilleulType;
use App\Repository\TopRepository;
use App\Repository\FilleulRepository;
use App\Repository\ParrainRepository;
use App\Form\RechercheFilleulFormType;
use App\Repository\DirectionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FilleulController extends AbstractController
{
    #[Route('/filleul', name: 'app_filleul')]
    public function indexFilleul(Request $request, FilleulRepository $filleulRepository): Response
    {
        $user = $this->getUser();   
        if ($user) {
            $role = $user->getRoles();
            if ($role[0] !== 'ROLE_ADMIN' && $role[0] !== 'ROLE_DIRECTION') {
                $this->addFlash('error', 'Vous n\'avez pas accès a cette page . . .');
                return $this->redirectToRoute('app_home'); // Redirige vers la page d'accueil ou une autre page appropriée
            }
            // Créer le formulaire de recherche
            $formRecherche = $this->createForm(RechercheFilleulFormType::class, new Filleul());
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

                if ($data->getMineure()) {
                    $criteria['mineure'] = $data->getMineure();
                }

                if ($data->getSpecialite()) {
                    $criteria['specialite'] = $data->getSpecialite();
                }

                if ($data->getParrain()) {
                    $criteria['parrain'] = $data->getParrain();
                }

                if ($data->getFaculte()) {
                    $criteria['faculte'] = $data->getFaculte();
                }
            }
        }else {
            $this->addFlash('error', 'Vous devez être connecté pour accéder a cette page . . .');
            return $this->redirectToRoute('app_login'); // Redirige vers la page d'accueil ou une autre page appropriée
        }

        // Utiliser findBy avec les critères
        $filleuls = $filleulRepository->searchFilleuls($criteria);

        return $this->render('filleul/index.html.twig', [
            'controller_name' => 'FilleulController',
            'filleuls' => $filleuls,
            'formRecherche' => $formRecherche->createView(),
        ]);
    }

    #[Route('/filleul/show-{id}', name: 'app_filleul.show')]
    public function show(int $id,FilleulRepository $filleulRepository ,TopRepository $topRepository , ParrainRepository $parrainRepository,DirectionRepository $directionRepository):Response{
        
        $user = $this->getUser();   
        if ($user) {
            // Rechercher le filleul par son ID
            $filleul = $filleulRepository->find($id);

            // Vérifier si le filleul n'existe pas
            if ($filleul === null) {
                $this->addFlash('error', 'Le filleul ne semble ne plus exister ou n\'existe pas.');
                return $this->redirectToRoute('app_home'); // Redirige vers la page d'accueil ou une autre page appropriée
            }

            $role = $user->getRoles();
            
            if ($role[0] === 'ROLE_PARRAIN') {
                $idRole = $user->getIdRole();
                if ($idRole!=null) {
                    $user = $parrainRepository->findOneBy(['id'=>$idRole]);
                }
            }elseif ($role[0]=== 'ROLE_TOP') {
                $idRole = $user->getIdRole();
                if ($idRole!=null) {
                    $user = $topRepository->findOneBy(['id'=>$idRole]);
                }
            }elseif ($role[0] === 'ROLE_ADMIN' || $role[0] === 'ROLE_DIRECTION') {
                $idRole = $user->getIdRole();
                if ($idRole!=null) {
                    $user = $directionRepository->findOneBy(['id'=>$idRole]);
                }else{
                    //erreur . . .
                }
            }else {
                //Message d'erreur ... Suspect
            }
        }else {
            $this->addFlash('error', 'Vous devez être connecté pour accéder a cette page . . .');
            return $this->redirectToRoute('app_login'); // Redirige vers la page d'accueil ou une autre page appropriée
        }
        return $this->render('filleul/show.html.twig', [
            'controller_name' => 'FilleulController',
            'filleul'=>$filleul,
            'user'=>$user,
        ]);
    }

    #[Route('/filleul/new', name: 'app_filleul.new')]
    #[Route('/filleul/edit-{id}', name: 'app_filleul.edit')]
    public function new(Filleul $filleul = null, Request $request, EntityManagerInterface $em): Response
    {
        $user = $this->getUser();   
        if ($user) {
            $role = $user->getRoles();
            if ($role[0] !== 'ROLE_ADMIN' && $role[0] !== 'ROLE_DIRECTION') {
                $this->addFlash('error', 'Vous n\'avez pas accès a cette page . . .');
                return $this->redirectToRoute('app_home'); // Redirige vers la page d'accueil ou une autre page appropriée
            }
            $isEdit = $filleul !== null;

            if (!$isEdit) {
                $filleul = new Filleul();
            }

            $top = null;
            if ($isEdit && $filleul->getParrain()) {
                $top = $filleul->getParrain()->getTop();
            }

            $form = $this->createForm(NouvFilleulType::class, $filleul, [
                'edit_mode' => $isEdit,
                'top' => $top,
            ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $newFilleul = $form->getData();
                $em->persist($newFilleul);
                $em->flush();

                $this->addFlash('success', 'Vous avez bien ajouté un nouveau filleul !');
                return $this->redirectToRoute('app_home');
            }
        }else {
            $this->addFlash('error', 'Vous devez être connecté pour accéder a cette page . . .');
            return $this->redirectToRoute('app_login'); // Redirige vers la page d'accueil ou une autre page appropriée
        }

        return $this->render('filleul/new.html.twig', [
            'controller_name' => 'FilleulController',
            'form' => $form->createView(),
        ]);
    }

    
}

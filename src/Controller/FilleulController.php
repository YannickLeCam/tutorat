<?php

namespace App\Controller;

use App\Entity\Filleul;
use App\Form\NouvFilleulType;
use App\Repository\DirectionRepository;
use App\Repository\FilleulRepository;
use App\Repository\ParrainRepository;
use App\Repository\TopRepository;
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
    public function show(Filleul $filleul, TopRepository $topRepository , ParrainRepository $parrainRepository,DirectionRepository $directionRepository):Response{
        $user = $this->getUser();
        if ($user) {
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

        return $this->render('filleul/new.html.twig', [
            'controller_name' => 'FilleulController',
            'form' => $form->createView(),
        ]);
    }

    
}

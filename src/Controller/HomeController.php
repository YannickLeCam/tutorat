<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\DirectionRepository;
use App\Repository\TopRepository;
use App\Repository\ParrainRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ParrainRepository $repositoryParrain,TopRepository $topRepository,DirectionRepository $directionRepository): Response
    {
        $user = $this->getUser();
        if ($user) {
            $role = $user->getRoles();
            
            if ($role[0] === 'ROLE_PARRAIN') {
                $idRole = $user->getIdRole();
                if ($idRole!=null) {
                    $user = $repositoryParrain->findOneBy(['id'=>$idRole]);
                }
                
            }elseif ($role[0]=== 'ROLE_TOP') {
                $idRole = $user->getIdRole();
                if ($idRole!=null) {
                    $user = $topRepository->findOneBy(['id'=>$idRole]);
                }
                $filleuls = $topRepository->findAllFilleuls($user->getId());
                return $this->render('home/top.html.twig',[
                    'controller-name' => 'HomeController',
                    'user' => $user,
                    'filleuls' => $filleuls,
                ]);
            }elseif ($role[0] === 'ROLE_ADMIN' || $role[0] === 'ROLE_DIRECTION') {
                $idRole = $user->getIdRole();
                if ($idRole!=null) {
                    $user = $directionRepository->findOneBy(['id'=>$idRole]);
                }else{
                    //erreur . . .
                }
                return $this->render('home/direction.html.twig',[
                    'controller-name' => 'HomeController',
                    'user' => $user,
                ]);
            }else {
                //Message d'erreur ... Suspect
            }
        }
        else{
            return $this->redirectToRoute('app_login');
        }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'user'=>$user,
        ]);
    }
}

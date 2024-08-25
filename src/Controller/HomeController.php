<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\TopRepository;
use App\Repository\ParrainRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ParrainRepository $repositoryParrain,TopRepository $topRepository): Response
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
            }elseif ($role[0] === 'ROLE_ADMIN') {
                
            }elseif ($role[0] === 'ROLE_DIRECTION'){

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

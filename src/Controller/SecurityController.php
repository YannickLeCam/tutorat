<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Repository\ParrainRepository;
use App\Repository\TopRepository;

class SecurityController extends AbstractController
{
    private $parrainRepository;
    private $topRepository;

    // Injection des repositories via le constructeur
    public function __construct(ParrainRepository $parrainRepository, TopRepository $topRepository)
    {
        $this->parrainRepository = $parrainRepository;
        $this->topRepository = $topRepository;
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Obtient l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier nom d'utilisateur saisi par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'controller_name' => 'SecurityController',
            'last_username' => $lastUsername,
            'error' => $error,
        ]);
    }

    #[Route(path: "/ajax/parrains", name:"ajax_parrains", methods:"GET")]
    public function getParrains(): JsonResponse
    {
        $parrains = $this->parrainRepository->findAll();
        $data = [];

        foreach ($parrains as $parrain) {
            $data[] = [
                'id' => $parrain->getId(),
                'name' => $parrain->getNom(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: "/ajax/tops", name:"ajax_tops", methods:"GET")]
    public function getTops(): JsonResponse
    {
        $tops = $this->topRepository->findAll();
        $data = [];

        foreach ($tops as $top) {
            $data[] = [
                'id' => $top->getId(),
                'name' => $top->getNom(),
            ];
        }

        return new JsonResponse($data);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

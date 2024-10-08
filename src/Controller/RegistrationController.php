<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\NouvAccountType;
use App\Security\EmailVerifier;
use App\Form\PasswordChangeType;
use App\Repository\TopRepository;
use App\Form\RegistrationFormType;
use Symfony\Component\Mime\Address;
use App\Repository\ParrainRepository;
use App\Repository\DirectionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;

class RegistrationController extends AbstractController
{
    public function __construct(private EmailVerifier $emailVerifier)
    {
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('tutorat@lyon.com', 'Duriff'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );

            // do anything else you need here, like send an email

            return $this->redirectToRoute('_profiler_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form,
        ]);
    }

    #[Route('/change-password', name: 'app_change_password')]
    public function changePassword(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PasswordChangeType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user = $this->getUser();
            $oldPassword = $form->get('oldPassword')->getData();
            $newPassword = $form->get('newPassword')->getData();
            $confirmPassword = $form->get('confirmPassword')->getData();

            // Vérifiez si l'ancien mot de passe est correct
            if (!$passwordHasher->isPasswordValid($user, $oldPassword)) {
                $this->addFlash('error', 'L\'ancien mot de passe est incorrect');
                return $this->redirectToRoute('app_change_password');
            }

            // Vérifiez si le nouveau mot de passe et la confirmation correspondent
            if ($newPassword !== $confirmPassword) {
                $this->addFlash('error', 'Les nouveaux mots de passe ne correspondent pas');
                return $this->redirectToRoute('app_change_password');
            }

            // Encodez et mettez à jour le nouveau mot de passe
            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $newPassword
                )
            );
            $entityManager->flush();

            $this->addFlash('success', 'Votre mot de passe a été changé avec succès');

            return $this->redirectToRoute('app_home'); // Redirigez vers la page de profil ou une autre page
        }

        return $this->render('registration/changePassword.html.twig', [
            'form' => $form->createView(),
            'controller_name' => "profile",
        ]);
    }

    #[Route(path: '/resetmdp-{id_role}-{role}', name: 'app_resetmdp')]
    public function resetMDP(int $id_role, string $role ,UserPasswordHasherInterface $passwordHasher,UserRepository $userRepository , EntityManagerInterface $entityManager): Response
    {
        if ($role=='parrain') {
            $role = 'ROLE_PARRAIN';
        }elseif ($role=='top') {
            $role = 'ROLE_TOP';
        }elseif ($role == 'direction') {
            $role = 'ROLE_DIRECTION';
        }else {
            //ERROR
        }
        
        $users = $userRepository->createQueryBuilder('u')
        ->where('u.idRole = :idRole')
        ->andWhere('u.roles LIKE :role')
        ->setParameter('idRole', $id_role)
        ->setParameter('role', '%"'.$role.'"%')
        ->getQuery()
        ->getResult();

        $user = $users[0];
        // Define the character sets
        $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $lowercase = 'abcdefghijklmnopqrstuvwxyz';
        $digits = '0123456789';
        $specialChars = '@!&$*%';

        // Ensure at least one character from each set is included
        $password = $uppercase[random_int(0, strlen($uppercase) - 1)] .
                    $lowercase[random_int(0, strlen($lowercase) - 1)] .
                    $digits[random_int(0, strlen($digits) - 1)] .
                    $specialChars[random_int(0, strlen($specialChars) - 1)];

        // Fill the rest of the password length with random characters from all sets
        $allChars = $uppercase . $lowercase . $digits . $specialChars;
        for ($i = 4; $i < 8; $i++) {
            $password .= $allChars[random_int(0, strlen($allChars) - 1)];
        }

        // Shuffle the password to ensure randomness
        $password = str_shuffle($password);
        $user->setPassword(
            $passwordHasher->hashPassword(
                $user,
                $password
            )
        );
        $entityManager->flush();
        

        return $this->render('security/reset.html.twig', [
            'controller_name' => 'SecurityController',
            'password' => $password,
            'user' => $user,

        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }

    #[Route('/registerManual-{role}', name: 'app_registerManual')]
    public function registerManual(String $role, Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager , ParrainRepository $parrainRepository , TopRepository $topRepository , DirectionRepository $directionRepository): Response
    {
        $user = new User();
        
        if ($role === 'parrain') {
            $roleSet = ['ROLE_PARRAIN'];
        } elseif ($role === 'top') {
            $roleSet = ['ROLE_TOP'];
        } elseif ($role === 'direction') {
            $roleSet = ['ROLE_DIRECTION'];
        } else {
            // Faire un message d'erreur
            $roleSet = ['ROLE_PARRAIN'];
        }
        
        $user->setRoles($roleSet);
        $form = $this->createForm(NouvAccountType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            if ($role === 'parrain') {
                $utilisateur = $parrainRepository->findOneBy(['id'=>$form->get('idRole')->getData()]);
            } elseif ($role === 'top') {
                $utilisateur = $topRepository->findOneBy(['id'=>$form->get('idRole')->getData()]);
            } elseif ($role === 'direction') {
                $utilisateur = $directionRepository->findOneBy(['id'=>$form->get('idRole')->getData()]);
            } else {
                // Faire un message d'erreur
                $utilisateur = $parrainRepository->findOneBy(['id'=>$form->get('idRole')->getData()]);

            }

            // Récupérer le prénom et le nom de l'utilisateur
            $firstName = $utilisateur->getPrenom();
            $lastName = $utilisateur->getNom();
    
            // Générer le mot de passe
            $generatedPassword = strtolower(substr($firstName, 0, 1) . $lastName); // Première lettre du prénom + nom, en minuscules
    
            // Définit le mot de passe généré
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $generatedPassword
                )
            );
            
            // Assurez-vous que l'idRole est défini
            $user->setIdRole($utilisateur->getId());
            $entityManager->persist($user);
            $entityManager->flush();
    
            // // générer une URL signée et l'envoyer par e-mail à l'utilisateur
            // $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
            //     (new TemplatedEmail())
            //         ->from(new Address('tutorat@lyon.com', 'Duriff'))
            //         ->to($user->getEmail())
            //         ->subject('Please Confirm your Email')
            //         ->htmlTemplate('registration/confirmation_email.html.twig')
            // );
    
            // Faites tout ce dont vous avez besoin ici, comme envoyer un e-mail
    
            return $this->redirectToRoute('app_registerManual', ['role' => $role]);
        }
    
        return $this->render('registration/manual.html.twig', [
            'form' => $form,
            'role' => $role,
            'controller_name' => 'RegisterController',
        ]);
    }
}

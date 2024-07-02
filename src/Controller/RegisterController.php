<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Entity\Client;
use App\Entity\User;

class RegisterController extends AbstractController
{
    #[Route('/register', name: 'register_client', methods: ['GET', 'POST'])]
    public function registerClient(Request $request, EntityManagerInterface $entityManager, UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $client = new Client();
        $user = new User();

        $nom = $request->request->get('nom');
        $prenom = $request->request->get('prenom');
        $telephone = $request->request->get('telephone');

        $email = $request->request->get('email');
        $password = $request->request->get('password');
        $errorMessage = '';

        if ($request->isMethod('POST') && $request->request->has('submit_button')) {
            // Check if the email already exists in the database
            $existingUserEmail = $entityManager->getRepository(User::class)->findOneByEmail($email);

            if ($existingUserEmail) {
                // Email already exists, return the form with an error message
                $errorMessage = 'This email is already in use. Please try with a different email.';
                return $this->render('security/new.html.twig', [
                    'error_message' => $errorMessage,
                ]);
            }

            $client->setNom($nom);
            $client->setPrenom($prenom);
            $client->setTelephone($telephone);

            $user->setEmail($email);
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $password
                )
            );
            $user->setRoles(["ROLE_CLIENT"]);

            $entityManager->persist($user);
            $entityManager->flush();

            $client->setUser($user);
            $entityManager->persist($client);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('security/new.html.twig', [
            'client' => $client,
            'error_message' => $errorMessage,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Usager;
use App\Form\UsagerType;
use App\Repository\UsagerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UsagerController extends AbstractController
{
    // Page d'accueil d'un usager
    public function index(): Response
    {
        $usager = $this->getUser();
        return $this->render('usager/index.html.twig', [
            'usager' => $usager,
        ]);
    }

    // Création d'un usager
    public function new(Request $request, UsagerRepository $usagerRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $usager = new Usager();
        $form = $this->createForm(UsagerType::class, $usager);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encodage du mot de passe
            $hashedPassword = $passwordHasher->hashPassword($usager, $usager->getPassword());
            $usager->setPassword($hashedPassword);
            // Définition du rôle de l’usager
            $usager->setRoles(["ROLE_CLIENT"]);
            // Persistance en base
            $usagerRepository->save($usager, true);
            // Redirection vers la page de login
            return $this->redirectToRoute('app_login');
        }

        // Affichage de la page de création d'un usager
        return $this->renderForm('usager/new.html.twig', [
            'usager' => $usager,
            'form' => $form
        ]);
    }

    // Page des commandes d'un usager
    public function commandes(): Response
    {
        // Récupération des commandes de l'usager connecté
        $usager = $this->getUser();
        $commandes = $usager->getCommandes();

        // Affichage de la page des commandes de l'usager
        return $this->render("commandes.html.twig", [
            "commandes" => $commandes
        ]);
    }
}

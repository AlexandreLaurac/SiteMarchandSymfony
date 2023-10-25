<?php
// src/Controller/NavbarController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\LigneCommandeRepository;
use App\Repository\ProduitRepository;
use App\Service\PanierService;


class BarController extends AbstractController
{
    const NB_PRODUITS = 5; // nb de produits les plus vendus, à afficher dans la sidebar rendue par rendreSidebar

    // Méthode de rendu de la navbar
    public function rendreNavbar(PanierService $service)
    {
        $nbProduits = $service->getNbProduits();
        return $this->render('navbar.html.twig', ['nbProduits' => $nbProduits]);
    }

    // Méthode de rendu de la sidebar
    public function rendreSidebar(ProduitRepository $pr, LigneCommandeRepository $lcr)
    {
        // Requête pour obtenir les NB_PRODUITS produits les plus vendus (retournant un tableau de tableaux associatifs [ 0 => ["id" => 1, "somme" => 45], 1 => ["id" => 5, "somme" => 32], 2 => ... ] )
        $donneesRequete = $lcr->getTopVentes(self::NB_PRODUITS);

        // Mise en forme des données reçues pour affichage (tableau de tableaux associatifs [ 0 => ["produit" => $produit1, "nbVentes" => $nbVentes1], 1 => ["produit" => $produit2, "nbVentes" => $nbVentes2], 2 => ...] )
        $donneesVues = $this->miseEnForme($pr, $donneesRequete);

        // Rendu de la vue
        return $this->render('sidebar.html.twig', [
            'donneesVues' => $donneesVues,
        ]);
    }

    // Méthode de mise en forme (avec en plus récupération) des données de la requête pour envoi à la vue
    public function miseEnForme(ProduitRepository $pr, array $donneesRequete): array
    {
        $donneesVues = [];
        foreach ($donneesRequete as $donneesProduit) {
            $donneesVues[] = ["produit" => $pr->find($donneesProduit['id']), "nbVentes" => $donneesProduit['somme']];
        }
        return $donneesVues;
    }
}

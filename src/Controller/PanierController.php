<?php
// src/Controller/PanierController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\PanierService;


class PanierController extends AbstractController
{

    // Page d'accueil du panier
    public function index(PanierService $panierService)
    {
        $nbProduits = $panierService->getNbProduits();
        $total = $panierService->getTotal();
        $contenuPanier = $panierService->getContenu();
        return $this->render("panier.html.twig", [
            "nbProduits" => $nbProduits,
            "total" => $total,
            "contenuPanier" => $contenuPanier
        ]);
    }

    // Ajout d'un article pour un produit donné
    public function ajouter(PanierService $panierService, $idProduit, $quantite)
    {
        $panierService->ajouterProduit($idProduit, $quantite);
        return $this->redirectToRoute('panier_index');
    }

    // Retrait d'un article pour un produit donné
    public function enlever(PanierService $panierService, $idProduit, $quantite)
    {
        $panierService->enleverProduit($idProduit, $quantite);
        return $this->redirectToRoute('panier_index');
    }

    // Suppression de tous les articles d'un produit donné
    public function supprimer(PanierService $panierService, $idProduit)
    {
        $panierService->supprimerProduit($idProduit);
        return $this->redirectToRoute('panier_index');
    }

    // Suppression de tous les produits du panier
    public function vider(PanierService $panierService)
    {
        $panierService->vider();
        return $this->redirectToRoute('panier_index');
    }

    // Transformation d'un panier en commande
    public function validation(PanierService $panierService)
    {
        $usager = $this->getUser();
        $panierService->panierToCommande($usager);
        return $this->redirectToRoute('usager_commandes');
    }
}

<?php
// src/Controller/BoutiqueController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Categorie;
use App\Repository\ProduitRepository;

class BoutiqueController extends AbstractController
{

    public function index()
    {
        $categories = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->findAll();
        $nbCategories = count($categories);
        return $this->render("boutique.html.twig", [
            "categories" => $categories,
            "nbCategories" => $nbCategories
        ]);
    }

    public function rayon(int $idCategorie)
    {
        $categorie = $this->getDoctrine()->getManager()->getRepository(Categorie::class)->find($idCategorie);
        $produits = $categorie->getProduits();
        $nbProduits = count($produits);
        return $this->render("rayon.html.twig", [
            "categorie" => $categorie,
            "produits" => $produits,
            "nbProduits" => $nbProduits
        ]);
    }

    public function rechercher(ProduitRepository $prodRep, String $texte)
    {
        // Récupération des produits correspondant au texte de recherche
        $produits = $prodRep->findProduitsByTexte($texte);
        $nbProduits = count($produits);

        // Rendu de la vue
        return $this->render('recherche.html.twig', [
            'texte' => $texte,
            'nbProduits' => $nbProduits,
            'produits' => $produits
        ]);
    }
}

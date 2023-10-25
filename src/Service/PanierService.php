<?php
// src/Service/PanierService.php
namespace App\Service;

use \DateTime;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Produit;
use App\Entity\Commande;
use App\Entity\LigneCommande;
use App\Entity\Usager;

// Service pour manipuler le panier et le stocker en session
class PanierService
{

    // Attributs
    const PANIER_SESSION = 'panier';  // nom de la variable de session du panier
    private $session;   // Le service Session
    private $panier;    // Tableau associatif idProduit => quantite (donc $this->panier[$i] = quantite du produit dont l'id = $i)
    private $em;        // Entity manager
    private $prodRep;   // repository de la classe Produit


    // Constructeur du service
    public function __construct(SessionInterface $session, EntityManagerInterface $em)
    {
        // Récupération du service session
        $this->session = $session;

        // Récupération du panier en session s'il existe, initialisation à vide sinon
        $this->panier = $this->session->get(self::PANIER_SESSION, []);

        // Récupération de l'entity manager
        $this->em = $em;

        // Récupération du repository de la classe Produit
        $this->prodRep = $em->getRepository(Produit::class);
    }


    // getContenu renvoie le contenu du panier sous la forme : tableau d'éléments [ "produit" => un produit, "quantite" => quantite ]
    public function getContenu()
    {
        $contenuPanier = [];
        foreach ($this->panier as $idProduit => $quantite) {
            $contenuPanier[] = ["produit" => $this->prodRep->find($idProduit), "quantite" => $quantite];
        }
        return $contenuPanier;
    }


    // getTotal renvoie le montant total du panier
    public function getTotal()
    {
        $total = 0.0;
        foreach ($this->panier as $idProduit => $quantite) {
            $total += $this->prodRep->find($idProduit)->getPrix() * $quantite;
        }
        return $total;
    }


    // getNbProduits renvoie le nombre de produits dans le panier
    public function getNbProduits()
    {
        $nbProduits = 0;
        foreach ($this->panier as $idProduit => $quantite) {
            $nbProduits += $quantite;
        }
        return $nbProduits;
    }


    // ajouterProduit ajoute au panier le produit $idProduit en quantite $quantite
    public function ajouterProduit(int $idProduit, int $quantite = 1)
    {
        if ($this->prodRep->find($idProduit) != NULL) {  // on n'ajoute un produit au panier que si l'id fourni correspond à un produit dans la base

            // Ajout du produit au panier
            if (isset($this->panier[$idProduit])) {
                $this->panier[$idProduit] += $quantite;
            } else {
                $this->panier[$idProduit] = $quantite;
            }

            // Sauvegarde du nouveau panier en session
            $this->session->set(self::PANIER_SESSION, $this->panier);
        }
    }


    // enleverProduit enlève du panier le produit $idProduit en quantite $quantite
    public function enleverProduit(int $idProduit, int $quantite = 1)
    {
        // Retrait du panier de la quantité de produit voulue
        if (isset($this->panier[$idProduit])) {
            $this->panier[$idProduit] = max(0, $this->panier[$idProduit] - $quantite);
        }

        // Sauvegarde du nouveau panier en session
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }


    // supprimerProduit supprime complètement le produit $idProduit du panier
    public function supprimerProduit(int $idProduit)
    {
        // Suppression de l'article du panier
        if (isset($this->panier[$idProduit])) {
            unset($this->panier[$idProduit]);
        }

        // Sauvegarde du nouveau panier en session
        $this->session->set(self::PANIER_SESSION, $this->panier);
    }


    // vider vide complètement le panier
    public function vider()
    {
        $this->panier = [];
        $this->session->remove(self::PANIER_SESSION);
    }


    // panierToCommande crée une commande correspondant au panier en cours
    public function panierToCommande(Usager $usager): ?Commande
    {
        if (count($this->panier) > 0) {

            //////// Objet commande

            // Instanciation de l'objet
            $commande = new Commande();

            // Ajout des attributs
            $commande->setUsager($usager);
            $commande->setDateCommande(new DateTime('now'));
            $commande->setStatut("creee");

            // Persistance en base
            $this->em->persist($commande);


            //////// Ensemble des lignes de commande

            foreach ($this->panier as $id => $quantite) {

                // Récupération du produit
                $produit = $this->prodRep->find($id);

                // Instanciation de la ligne
                $ligneCourante = new LigneCommande();

                // Ajout des attributs
                $ligneCourante->setQuantite($quantite);
                $ligneCourante->setPrix($produit->getPrix());
                $ligneCourante->setProduit($produit);
                $ligneCourante->setCommande($commande);

                // Persistance en base
                $this->em->persist($ligneCourante);
            }

            $this->em->flush();

            // On vide la panier à la fin de l'opération
            $this->vider();
        } else {
            $commande = null;
        }

        // Retour de la commande
        return $commande;
    }
}

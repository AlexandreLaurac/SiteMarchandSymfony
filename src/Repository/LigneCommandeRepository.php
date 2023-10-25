<?php

namespace App\Repository;

use App\Entity\LigneCommande;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<LigneCommande>
 *
 * @method LigneCommande|null find($id, $lockMode = null, $lockVersion = null)
 * @method LigneCommande|null findOneBy(array $criteria, array $orderBy = null)
 * @method LigneCommande[]    findAll()
 * @method LigneCommande[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LigneCommandeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, LigneCommande::class);
    }

    public function save(LigneCommande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(LigneCommande $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    /* Quelques explications sur la requête pour obtenir les "top ventes" 

    Les produits les plus vendus sont ceux qui ont fait l'objet du plus grand nombre de commandes, toutes commandes confondues. De plus, les différentes ventes d'un produit apparaissent dans la table ligne_commande.
    Pour connaitre le nombre de ventes total par produit, on regroupe les lignes de commandes par produit (=> GROUP BY) et on somme la quantité de produit demandée pour chaque (=> fonction d'aggrégation SUM)

    Cela donne le début de requête suivant :
    SELECT produit_id, SUM(quantite) as somme FROM ligne_commande GROUP BY produit_id ;

    Pour avoir les N produits LES PLUS vendus, on ajoute un ordre et une limite :
    SELECT produit_id, SUM(quantite) as somme FROM ligne_commande GROUP BY produit_id ORDER BY somme DESC LIMIT N;

    La requête écrite dans la méthode suivante est adaptée à DQL.

    */
    public function getTopVentes(int $nbProduits)
    {
        // Récupération de l'entity manager
        $em = $this->getEntityManager();

        // Requête
        $query = $em->createQuery(
            'SELECT p.id, SUM(lc.quantite) AS somme FROM App\Entity\LigneCommande lc JOIN lc.Produit p GROUP BY p.id ORDER BY somme DESC'
        )->setMaxResults($nbProduits);

        // Renvoi du résultat
        return $query->getResult();
    }
}

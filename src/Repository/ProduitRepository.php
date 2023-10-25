<?php

namespace App\Repository;

use App\Entity\Produit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Produit>
 *
 * @method Produit|null find($id, $lockMode = null, $lockVersion = null)
 * @method Produit|null findOneBy(array $criteria, array $orderBy = null)
 * @method Produit[]    findAll()
 * @method Produit[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Produit::class);
    }

    public function save(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Produit $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findProduitsByCategorie(int $idCategorie): array
    {
        $entityManager = $this->getEntityManager();
        $query = $entityManager->createQuery(
            'SELECT p
            FROM App\Entity\Produit p
            WHERE p.categorie_id = :idCategorie'
        )->setParameter('idCategorie', $idCategorie);
        // returns an array of Product objects
        return $query->getResult();
    }


    /**
     * @return Produit[]
     */
    public function findProduitsByTexte(String $texte): array
    {
        $query = $this->createQueryBuilder('p')
            ->where('LOWER(p.libelle) LIKE :texte')->orWhere('LOWER(p.texte) LIKE :texte')
            ->setParameter('texte', '%' . strtolower($texte) . '%')
            ->orderBy('p.libelle', 'ASC')
            ->getQuery();

        return $query->getResult();
    }
}

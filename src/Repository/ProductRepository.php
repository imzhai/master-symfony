<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    // /**
    //  * @return Product[] Returns an array of Product objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Product
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function findAllGreaterThanPrice($price): array
    {
        // Requête avec le queryBuilder
        $qb = $this->createQueryBuilder('p'); // SELECT * FROM product...
        $qb->andWhere('p.price > :price'); // WHERE p.price > :price
        $qb->setParameter('price', $price); // est égal au bindValue

        // if (??????){
        //     $qb->andWhere('....'); // AND....
        //     $qb->setParameter('price', $price);
        // }

        $qb->orderBy('p.price', 'ASC'); // ORDER BY price ASC

        //debug de la requête
        //dump($qb->getQuery()->getSql());

        return $qb->getQuery()->getResult(); // Execute le requête
    }


    /**
     *  Permet de récupérer un seul produit
     */
    public function findOneGreaterThanPrice($price): Product
    {
        // Requête avec le queryBuilder
        $qb = $this->createQueryBuilder('p') // SELECT * FROM product...
                ->andWhere('p.price > :price') // WHERE p.price > :price
                ->setParameter('price', $price) // est égal au bindValue
                ->orderBy('p.price', 'DESC') // ORDER BY price ASC
                ->setMaxResults(1) // Limit 1
                ->getQuery();
    
        return $qb->getOneOrNullResult(); // Execute le requête
        //debug de la requête
        //dump($qb->getQuery()->getSql());

        
    }


    /**
     * Permer de retourner les 4 produits les plus chers de la base de données
     * Cette méthode devra être appelée sur notre page d'accueil afin d'afficher les 4 produits
     */

     public function findMoreExpensive(int $number = 4)
    {
        $qb = $this->createQueryBuilder('p')
            ->orderBy('p.price', 'DESC')
            ->setMaxResults($number)
            ->getQuery();

        return $qb->getResult();    

    }


    public function findAllWithUser()
    {
        $qb = $this->createQueryBuilder('p')
            // leftJoin renvoie tous les produits même ceux sans user
            ->leftJoin('p.user', 'u')
            // innerJoin ou join renvoie uniquement les produits avec un user
            // ->join('p.user', 'u')
            ->addSelect('u')
            ->getQuery();
        return $qb->getResult();
    }



}

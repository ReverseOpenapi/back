<?php

namespace App\Repository;

use App\Entity\PathItem;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PathItem|null find($id, $lockMode = null, $lockVersion = null)
 * @method PathItem|null findOneBy(array $criteria, array $orderBy = null)
 * @method PathItem[]    findAll()
 * @method PathItem[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PathItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PathItem::class);
    }

    // /**
    //  * @return PathItem[] Returns an array of PathItem objects
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
    public function findOneBySomeField($value): ?PathItem
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

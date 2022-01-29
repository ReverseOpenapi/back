<?php

namespace App\Repository;

use App\Entity\Schema;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Schema|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schema|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schema[]    findAll()
 * @method Schema[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchemaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Schema::class);
    }

    // /**
    //  * @return Schema[] Returns an array of Schema objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Schema
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

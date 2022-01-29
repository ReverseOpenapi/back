<?php

namespace App\Repository;

use App\Entity\ApiKeyLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ApiKeyLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ApiKeyLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ApiKeyLocation[]    findAll()
 * @method ApiKeyLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ApiKeyLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ApiKeyLocation::class);
    }

    // /**
    //  * @return ApiKeyLocation[] Returns an array of ApiKeyLocation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ApiKeyLocation
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

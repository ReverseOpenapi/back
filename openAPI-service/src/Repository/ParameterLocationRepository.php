<?php

namespace App\Repository;

use App\Entity\ParameterLocation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ParameterLocation|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParameterLocation|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParameterLocation[]    findAll()
 * @method ParameterLocation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParameterLocationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParameterLocation::class);
    }

    // /**
    //  * @return ParameterLocation[] Returns an array of ParameterLocation objects
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
    public function findOneBySomeField($value): ?ParameterLocation
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

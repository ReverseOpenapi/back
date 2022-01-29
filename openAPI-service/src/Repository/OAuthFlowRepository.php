<?php

namespace App\Repository;

use App\Entity\OAuthFlow;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OAuthFlow|null find($id, $lockMode = null, $lockVersion = null)
 * @method OAuthFlow|null findOneBy(array $criteria, array $orderBy = null)
 * @method OAuthFlow[]    findAll()
 * @method OAuthFlow[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OAuthFlowRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OAuthFlow::class);
    }

    // /**
    //  * @return OAuthFlow[] Returns an array of OAuthFlow objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?OAuthFlow
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

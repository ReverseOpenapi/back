<?php

namespace App\Repository;

use App\Entity\OAuthScope;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OAuthScope|null find($id, $lockMode = null, $lockVersion = null)
 * @method OAuthScope|null findOneBy(array $criteria, array $orderBy = null)
 * @method OAuthScope[]    findAll()
 * @method OAuthScope[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OAuthScopeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OAuthScope::class);
    }

    // /**
    //  * @return OAuthScope[] Returns an array of OAuthScope objects
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
    public function findOneBySomeField($value): ?OAuthScope
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

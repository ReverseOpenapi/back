<?php

namespace App\Repository;

use App\Entity\OAuthFlowType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OAuthFlowType|null find($id, $lockMode = null, $lockVersion = null)
 * @method OAuthFlowType|null findOneBy(array $criteria, array $orderBy = null)
 * @method OAuthFlowType[]    findAll()
 * @method OAuthFlowType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OAuthFlowTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OAuthFlowType::class);
    }

    // /**
    //  * @return OAuthFlowType[] Returns an array of OAuthFlowType objects
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
    public function findOneBySomeField($value): ?OAuthFlowType
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

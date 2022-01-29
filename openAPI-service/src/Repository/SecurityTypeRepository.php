<?php

namespace App\Repository;

use App\Entity\SecurityType;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SecurityType|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecurityType|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecurityType[]    findAll()
 * @method SecurityType[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecurityTypeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecurityType::class);
    }

    // /**
    //  * @return SecurityType[] Returns an array of SecurityType objects
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
    public function findOneBySomeField($value): ?SecurityType
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

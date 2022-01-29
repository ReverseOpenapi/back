<?php

namespace App\Repository;

use App\Entity\SecurityScheme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method SecurityScheme|null find($id, $lockMode = null, $lockVersion = null)
 * @method SecurityScheme|null findOneBy(array $criteria, array $orderBy = null)
 * @method SecurityScheme[]    findAll()
 * @method SecurityScheme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SecuritySchemeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SecurityScheme::class);
    }

    // /**
    //  * @return SecurityScheme[] Returns an array of SecurityScheme objects
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
    public function findOneBySomeField($value): ?SecurityScheme
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

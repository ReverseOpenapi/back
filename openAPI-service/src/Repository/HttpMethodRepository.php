<?php

namespace App\Repository;

use App\Entity\HttpMethod;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HttpMethod|null find($id, $lockMode = null, $lockVersion = null)
 * @method HttpMethod|null findOneBy(array $criteria, array $orderBy = null)
 * @method HttpMethod[]    findAll()
 * @method HttpMethod[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HttpMethodRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HttpMethod::class);
    }

    // /**
    //  * @return HttpMethod[] Returns an array of HttpMethod objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HttpMethod
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

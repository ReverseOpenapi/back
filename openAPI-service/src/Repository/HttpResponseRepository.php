<?php

namespace App\Repository;

use App\Entity\HttpResponse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HttpResponse|null find($id, $lockMode = null, $lockVersion = null)
 * @method HttpResponse|null findOneBy(array $criteria, array $orderBy = null)
 * @method HttpResponse[]    findAll()
 * @method HttpResponse[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HttpResponseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HttpResponse::class);
    }

    // /**
    //  * @return HttpResponse[] Returns an array of HttpResponse objects
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
    public function findOneBySomeField($value): ?HttpResponse
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

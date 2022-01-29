<?php

namespace App\Repository;

use App\Entity\OpenApiDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method OpenApiDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method OpenApiDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method OpenApiDocument[]    findAll()
 * @method OpenApiDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpenApiDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OpenApiDocument::class);
    }

    // /**
    //  * @return OpenApiDocument[] Returns an array of OpenApiDocument objects
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
    public function findOneBySomeField($value): ?OpenApiDocument
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

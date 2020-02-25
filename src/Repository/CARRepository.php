<?php

namespace App\Repository;

use App\Entity\CAR;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CAR|null find($id, $lockMode = null, $lockVersion = null)
 * @method CAR|null findOneBy(array $criteria, array $orderBy = null)
 * @method CAR[]    findAll()
 * @method CAR[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CARRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CAR::class);
    }

    // /**
    //  * @return CAR[] Returns an array of CAR objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?CAR
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

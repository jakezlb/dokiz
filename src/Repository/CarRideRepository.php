<?php

namespace App\Repository;

use App\Entity\CarRide;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method CarRide|null find($id, $lockMode = null, $lockVersion = null)
 * @method CarRide|null findOneBy(array $criteria, array $orderBy = null)
 * @method CarRide[]    findAll()
 * @method CarRide[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRideRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CarRide::class);
    }

    // /**
    //  * @return CarRide[] Returns an array of CarRide objects
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
    public function findOneBySomeField($value): ?CarRide
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

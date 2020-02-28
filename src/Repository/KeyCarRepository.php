<?php

namespace App\Repository;

use App\Entity\KeyCar;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method KeyCar|null find($id, $lockMode = null, $lockVersion = null)
 * @method KeyCar|null findOneBy(array $criteria, array $orderBy = null)
 * @method KeyCar[]    findAll()
 * @method KeyCar[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeyCarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KeyCar::class);
    }

    // /**
    //  * @return KeyCar[] Returns an array of KeyCar objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('k.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?KeyCar
    {
        return $this->createQueryBuilder('k')
            ->andWhere('k.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

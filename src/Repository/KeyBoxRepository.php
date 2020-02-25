<?php

namespace App\Repository;

use App\Entity\KeyBox;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method KeyBox|null find($id, $lockMode = null, $lockVersion = null)
 * @method KeyBox|null findOneBy(array $criteria, array $orderBy = null)
 * @method KeyBox[]    findAll()
 * @method KeyBox[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KeyBoxRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KeyBox::class);
    }

    // /**
    //  * @return KeyBox[] Returns an array of KeyBox objects
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
    public function findOneBySomeField($value): ?KeyBox
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

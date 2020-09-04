<?php

namespace App\Repository;

use App\Entity\Reservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Monolog\Logger;

/**
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    
    /**
     * @return Reservation[] Returns an array of Car objects
    */
    
    public function findBySociety($value)
    {
        return $this->createQueryBuilder('r')
            ->leftJoin('r.car', 'c')
            ->andWhere('c.society = :val')            
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }
    
    
    /**
     * @return Reservation[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findByUser($id): array
    {

        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT r.id
            FROM reservation r
            WHERE r.user_id IN('.$id.')';
        $stmt = $conn->query($sql);
        // here you go:
        $id_resa= $stmt->fetchAll();
        $array_id =[];
        foreach ($id_resa as $row) {
            array_push($array_id, $this->find($row["id"])) ;
        }
        return $array_id;
    }

    public function findAllConfirmed($confirmed) {
        return $this->createQueryBuilder('r')
            ->andWhere('r.is_confirmed = :val')
            ->setParameter('val', $confirmed)
            ->getQuery()
            ->getResult()
            ;
    }

    // /**
    //  * @return Reservation[] Returns an array of Reservation objects

    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reservation
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

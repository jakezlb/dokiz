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

    /**
     * @return carRide[]
     */
    public function findByDate(): array
    {
        return $this->findBy(array(), array('date_start' => 'ASC'));
    }

    /**
     * @return CarRide[]
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findByUser($id): array
    {

        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT p.car_ride_id
            FROM passenger p
            WHERE p.user_id IN('.$id.')';
        $stmt = $conn->query($sql);
        // here you go:
        $id_resa= $stmt->fetchAll();
        $array_id =[];
        foreach ($id_resa as $row) {
            array_push($array_id, $this->find($row["id"])) ;
        }
        return $array_id;
    }

    public function findByMonth($month)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = 'SELECT COUNT(cr.id)
            FROM car_ride cr
            WHERE MONTH(cr.date_start) = '.$month .'
            AND YEAR(cr.date_start) = 2020';
        $stmt = $conn->query($sql);
        // here you go:
        $result = $stmt->fetch();
        return $result;
    }

    public function findBySociety($value)
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.reservation', 'r')
            ->leftJoin('r.car', 'c')
            ->andWhere('c.society = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->getQuery()
            ->getResult()
            ;
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

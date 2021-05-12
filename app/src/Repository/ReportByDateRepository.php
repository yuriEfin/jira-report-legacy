<?php

namespace App\Repository;

use App\Entity\ReportByDate;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ReportByDate|null find($id, $lockMode = null, $lockVersion = null)
 * @method ReportByDate|null findOneBy(array $criteria, array $orderBy = null)
 * @method ReportByDate[]    findAll()
 * @method ReportByDate[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReportByDateRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ReportByDate::class);
    }

    // /**
    //  * @return ReportByDate[] Returns an array of ReportByDate objects
    //  */
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
    public function findOneBySomeField($value): ?ReportByDate
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

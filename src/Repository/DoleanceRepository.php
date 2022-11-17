<?php

namespace App\Repository;

use App\Entity\Doleance;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Doleance|null find($id, $lockMode = null, $lockVersion = null)
 * @method Doleance|null findOneBy(array $criteria, array $orderBy = null)
 * @method Doleance[]    findAll()
 * @method Doleance[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DoleanceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Doleance::class);
    }

    // /**
    //  * @return Doleance[] Returns an array of Doleance objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */
        /**
     * @param int $month
     * @param int $year
     * 
     * @return object[]
     */
    public function findByDate($year = null, $month = null)
    {
        if ($month === null) {
            $month = (int) date('m');
        }

        if ($year === null) {
            $year = (int) date('Y');
        }
        


        $startDate = new \DateTimeImmutable("$year-$month-01 00:00:00");
        $endDate = $startDate->modify('last day of this month')->setTime(23, 59, 59);
    
        $qb = $this->createQueryBuilder('d')
                   ->select('count(d.id)')
                   ->where('d.createdAt BETWEEN :start AND :end')
                   ->setParameter('start', $startDate->format('Y-m-d H:i:s'))
                   ->setParameter('end', $endDate->format('Y-m-d H:i:s'));

        return $qb->getQuery()->getSingleScalarResult();
    }

    public function myFindAll()
    {
        return $this->createQueryBuilder('d')->where('d.isPublished = true')
            
          
            ->orderBy('d.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    /*
    public function findOneBySomeField($value): ?Doleance
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

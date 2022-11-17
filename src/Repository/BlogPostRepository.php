<?php

namespace App\Repository;

use App\Entity\BlogPost;
use App\Entity\CategoryPost;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method BlogPost|null find($id, $lockMode = null, $lockVersion = null)
 * @method BlogPost|null findOneBy(array $criteria, array $orderBy = null)
 * @method BlogPost[]    findAll()
 * @method BlogPost[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BlogPostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BlogPost::class);
    }

    // /**
    //  * @return BlogPost[] Returns an array of BlogPost objects
    //  */
    
    public function findLatest()
    {
        return $this->createQueryBuilder('b')
            //->andWhere('b.exampleField = :val')
            //->setParameter('val', $value)
            //->orderBy('b.id', 'ASC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findHome() {
        return $this->createQueryBuilder('b')
            //->andWhere('b.exampleField = :val')
            //->setParameter('val', $value)
            //->orderBy('b.id', 'ASC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;

    }

    public function findByCategory($nom)
    {
        return $this->createQueryBuilder('b')
           
            //->andWhere('b.exampleField = :val')
            //->setParameter('val', $value)
            //->orderBy('b.id', 'ASC')
            ->leftJoin('b.categories', 'c')
            ->addSelect('c')
            ->where('c.name = :nom' )
            ->setParameter('nom', $nom)
            ->orderBy('b.createdAt', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
    

    /*
    public function findOneBySomeField($value): ?BlogPost
    {
        return $this->createQueryBuilder('b')
            ->andWhere('b.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

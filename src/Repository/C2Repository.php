<?php

namespace App\Repository;

use App\Entity\C2;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method C2|null find($id, $lockMode = null, $lockVersion = null)
 * @method C2|null findOneBy(array $criteria, array $orderBy = null)
 * @method C2[]    findAll()
 * @method C2[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class C2Repository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, C2::class);
    }

    // /**
    //  * @return C2[] Returns an array of C2 objects
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
    public function findOneBySomeField($value): ?C2
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

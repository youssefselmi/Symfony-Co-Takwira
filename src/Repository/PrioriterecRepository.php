<?php

namespace App\Repository;

use App\Entity\Prioriterec;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Locations;
use Doctrine\DBAL\DBALException;


/**
 * @method Prioriterec|null find($id, $lockMode = null, $lockVersion = null)
 * @method Prioriterec|null findOneBy(array $criteria, array $orderBy = null)
 * @method Prioriterec[]    findAll()
 * @method Prioriterec[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class PrioriterecRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Prioriterec::class);
    }
 
    


    

   
    // /**
    //  * @return Prioriterec[] Returns an array of Prioriterec objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Prioriterec
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

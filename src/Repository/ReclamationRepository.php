<?php

namespace App\Repository;

use App\Entity\Reclamation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Locations;
use Doctrine\DBAL\DBALException;

/**
 * @method Reclamation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamation[]    findAll()
 * @method Reclamation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class ReclamationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamation::class);
    }

    public function checkDateReclam1Day()
    {

        // $conn = $this->getEntityManager()->getConnection();
        // $aaa = $this->getEntityManager();
  

       
        // $query = $aaa->createQuery(
        //     'SELECT (r.idrec) FROM   App\Entity\Reclamation r WHERE r.StatusRec = `non traite`  '
        // );

        // $nbrss=($query->getResult());
       

        //     $sql2 = "UPDATE `prioriterec` SET `PrioriteRec`=\"High\"  where  idRec = "."'".$nbrss."'" ;
        //     $stmt2 = $conn->prepare($sql2);
        //     $stmt2->execute();  
 
      
    }
   
public function findReclamationsBySujet($sujet,$status,$order){
    $em = $this->getEntityManager();
    if($order=='DESC') {
       $query = $em->createQuery(
           'SELECT r FROM App\Entity\Reclamation r   where r.sujetrec like :suj  and r.statusrec like :status order by r.idrec DESC '
       );
       $query->setParameter('suj', $sujet . '%');
       $query->setParameter('status', $status . '%');
    }
    else{
        $query = $em->createQuery(
            'SELECT r FROM App\Entity\Reclamation r   where r.sujetrec like :suj  and r.statusrec like :status order by r.idrec ASC '
        );
        $query->setParameter('suj', $sujet . '%');
        $query->setParameter('status', $status . '%');
    }       
    return $query->getResult();
}
public function find_Nb_Rec_Par_Status($status){

    $em = $this->getEntityManager();

    $query = $em->createQuery(
        'SELECT DISTINCT  count(r.idrec) FROM   App\Entity\Reclamation r  where r.statusrec = :status   '
    );
    $query->setParameter('status', $status);
    return $query->getResult();
}
   
    // /**
    //  * @return Reclamation[] Returns an array of Reclamation objects
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
    public function findOneBySomeField($value): ?Reclamation
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

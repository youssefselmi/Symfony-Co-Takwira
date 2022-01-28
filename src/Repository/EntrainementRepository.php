<?php

namespace App\Repository;

use App\Entity\Entrainement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Locations;

/**
 * @method Entrainement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrainement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrainement[]    findAll()
 * @method Entrainement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */

class EntrainementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entrainement::class);
    }

    public function findProduitsBySujet($type,$duree){
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT r FROM App\Entity\Entrainement r   where r.type like :suj  and r.duree like :status  '
        );


        $query->setParameter('suj', $type . '%');
        $query->setParameter('status', $duree . '%');

        return $query->getResult();
    }








  /*  public function findEntrainementBySujet($type,$status,$order){
        $em = $this->getEntityManager();
        if($order=='DESC') {
            $query = $em->createQuery(
                'SELECT r FROM App\Entity\Reclamation r   where r.sujetrec like :suj  and r.statusrec like :status order by r.idrec DESC '
            );
            $query->setParameter('suj', $type . '%');
            $query->setParameter('status', $status . '%');
        }
        else{
            $query = $em->createQuery(
                'SELECT r FROM App\Entity\Reclamation r   where r.sujetrec like :suj  and r.statusrec like :status order by r.idrec ASC '
            );
            $query->setParameter('suj', $type . '%');
            $query->setParameter('status', $status . '%');
        }
        return $query->getResult();
    }*/

    public function find_Nb_Rec_Par_Status($type){

        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT DISTINCT  count(r.idEntrainement) FROM   App\Entity\Entrainement r  where r.type = :type   '
        );
        $query->setParameter('type', $type);
        return $query->getResult();
    }


















}

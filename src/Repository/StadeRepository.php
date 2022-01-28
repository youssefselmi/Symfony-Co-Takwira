<?php


namespace App\Repository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Stade;




/**
 * @method Stade|null find($id, $lockMode = null, $lockVersion = null)
 * @method Stade|null findOneBy(array $criteria, array $orderBy = null)
 * @method Stade[]    findAll()
 * @method Stade[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */



class StadeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stade::class);
    }
    public function findNomStade($id)
    {
        $query = $this->getEntityManager()->createQuery(" SELECT r FROM App:stade r WHERE r.idStade
        
        ='$id'");
        return $query->getResult();
    }
    public function findStade($id)
    {
        $query = $this->getEntityManager()->createQuery(" SELECT r FROM App:stade r WHERE r.idStade
        
        ='$id'");
        return $query->getResult();
    }

    public function findByNom($nom)
    {
        $query = $this->getEntityManager()->createQuery(" SELECT r FROM App:stade r WHERE r.nomStade
        
        ='$nom'");
        return $query->getResult();
    }

}
<?php

namespace App\Repository;

use App\Entity\Matchs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Matchs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Matchs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Matchs[]    findAll()
 * @method Matchs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MatchsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Matchs::class);
    }

    // /**
    //  * @return Matchs[] Returns an array of Matchs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Matchs
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * get all posts
     *
     * @return array
     */
    public function findAllMatchs()
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT a
         FROM App:Matchs a
      
         ORDER BY a.id_match DESC'
            )
            ->getArrayResult();
    }

    /**
     * get one by id
     *
     * @param integer $id
     *
     * @return array
     */
    public function findOneById($id)
    {
        /*return $this->getEntityManager()
            ->createQuery(
                "SELECT a, u.username
       FROM App:Matchs
       a JOIN a.user u
        WHERE a.id = id"
            )
            ->setParameter('id', $id)
            ->getArrayResult();*/
    }


    /**
     * get one by id
     *
     * @param integer $id
     *
     * @return object or null
     */
    public function findMatchByid($id)
    {
        try {
            return $this->getEntityManager()
                ->createQuery(
                    "SELECT p
                FROM App:Matchs
                p WHERE p.idMatch =:id"
                )
                ->setParameter('id', $id)
                ->getOneOrNullResult();
        } catch (NonUniqueResultException $e) {
        }
    }
    public function findEntitiesByString($str){
        return $this->getEntityManager()
            ->createQuery(
                'SELECT p
                FROM App:Matchs p
                WHERE p.description LIKE :str
                OR p.status LIKE :str
                OR p.score LIKE :str
                OR p.date LIKE :str
                OR p.heureDeb LIKE :str
                OR p.heureFin LIKE :str     
                '

            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }
    public function verifierExiste($id1,$id2,$date)
    {


        $query = $this->getEntityManager()->createQuery(" SELECT r FROM App:matchs r WHERE r.idEquipe1
        
        ='$id1' or r.idEquipe1='$id2' and r.idEquipe2='$id2'  or r.idEquipe2='$id1' and r.date='$date' ");
        return $query->getResult();


    }
    public function OrderByDateAsc(){

        $em = $this->getEntityManager();
        $query = $em->createQuery('
                select p from App:matchs p order by p.date ASC');
        return $query->getResult();
    }
    public function OrderByDateDsc(){

        $em = $this->getEntityManager();
        $query = $em->createQuery('
                select p from App:matchs p order by p.date DESC');
        return $query->getResult();
    }
    public function OrderByHeureAsc(){

        $em = $this->getEntityManager();
        $query = $em->createQuery('
                select p from App:matchs p order by p.heureDeb ASC');
        return $query->getResult();
    }
    public function OrderByHeureDsc(){

        $em = $this->getEntityManager();
        $query = $em->createQuery('
                select p from App:matchs p order by p.heureDeb DESC');
        return $query->getResult();
    }

    public function findMatchTermine($status)
    {

        $em = $this->getEntityManager();
        $query = $em->createQuery(" SELECT r FROM App:matchs r WHERE r.status
        
        ='$status'  ");

        return $query->getResult();
    }
public function nbMatch($status)
{
    $em = $this->getEntityManager();
    return $em->createQuery("select count(r.idMatch) FROM  App:matchs r WHERE r.status

        ='$status'  ")  ->getSingleScalarResult();
}
    public function findVoteByUser($id)
    {
        $query = $this->getEntityManager()->createQuery(" SELECT r FROM App:Vote r WHERE r.idUser
        
        ='$id'");
        return $query->getResult();
    }

    public function findVote($id)
    {
        $query = $this->getEntityManager()->createQuery(" SELECT r FROM App:Vote r WHERE r.idMatch
        
        ='$id'");
        return $query->getResult();
    }
    public function findVoteTotal($id)
    {
        $query = $this->getEntityManager()->createQuery(" SELECT sum(r.vote) total, r.idMatch idM FROM App:Vote r WHERE r.idMatch
        
        ='$id'");
        return $query->getResult();
    }
    public function findMatchV()
    {
        $query = $this->getEntityManager()->createQuery(" SELECT  avg(r.vote) total , r.idMatch idM FROM App:Vote r group by r.idMatch");
        return $query->getResult();
    }

    public function findEqpByNom($nom)
    {
        $query = $this->getEntityManager()->createQuery(" SELECT r FROM App:equipe r WHERE r.nomEquipe
        
        ='$nom'");
        return $query->getResult();
    }
    public function findEqp($id)
    {
        $query = $this->getEntityManager()->createQuery(" SELECT r FROM App:equipe r WHERE r.idE
        
        ='$id'");
        return $query->getResult();
    }
}

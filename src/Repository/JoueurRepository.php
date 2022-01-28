<?php


namespace App\Repository;


use App\Entity\Equipe;
use App\Entity\Joueur;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\DBALException;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Locations;
use Doctrine\DBAL\Driver\Exception;
use phpDocumentor\Reflection\Types\Null_;

/**
 * @method Joueur|null find($id, $lockMode = null, $lockVersion = null)
 * @method Joueur|null findOneBy(array $criteria, array $orderBy = null)
 * @method Joueur[]    findAll()
 * @method Joueur[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class JoueurRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Joueur::class);
    }



    public function mise_a_jour()
    {

        $conn = $this->getEntityManager()->getConnection();

        $sql = '
           select * FROM `joueur`   ';
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $jouers=$stmt->fetchAll();
      for($i=0;$i<sizeof($jouers);$i++ )
      {
          $datenaissance=$jouers[$i]['date_naissance'];
          $age1=$jouers[$i]['age_joueur'];
          $aujourdhui = date("Y-m-d");
          $diff = date_diff(date_create($datenaissance), date_create($aujourdhui));
          $agenew=$diff->format('%y');
                 $idJ= $jouers[$i]['id_joueur'];
          if($agenew>$age1)

              { $sql1 = '       update `joueur` set age_joueur='.$agenew.' where id_joueur='.$idJ;
         
                  $stmt1 = $conn->prepare($sql1);
                  $stmt1->execute();
              }
          if($jouers[$i]['categorie']=="junior")
          {
              if($agenew>18)
              {

                  $sql2 = '
           update `joueur` set categorie="sunior" where id_joueur='.$idJ;
                  $stmt1 = $conn->prepare($sql2);
                  $stmt1->execute();

    }
          }


      }

    }














    public function findProduitsBySujet($nomJoueur,$age){
        $em = $this->getEntityManager();

        $query = $em->createQuery(
            'SELECT r FROM App\Entity\Joueur r   where r.nomJoueur like :suj  and r.ageJoueur like :status  '
        );


        $query->setParameter('suj', $nomJoueur . '%');
        $query->setParameter('status', $age . '%');

        return $query->getResult();
    }








    public function statistique_abo()
    {

        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "SELECT nom_joueur, age_joueur FROM `joueur` ";

        try {
            $stmt = $conn->prepare($sql);
        } catch (DBALException $e) {
        }
        $stmt->execute();
        return $stmt->fetchAll();

    }






}
<?php


namespace coachBundle\Repository;
namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\DBAL\Driver\Exception;
use Doctrine\Persistence\ManagerRegistry;
use phpDocumentor\Reflection\Types\Null_;


/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */



class UserRepository extends ServiceEntityRepository
{

    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }






    public function max_id_joueur()
    {

        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "SELECT MAX(id_joueur) as id FROM `joueur`";

        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
        }
        $stmt->execute();
        return $stmt->fetch();

    }




    public function max_id_coach()
    {
        $conn = $this->getEntityManager()
            ->getConnection();
        $sql = "SELECT MAX(id_coach) as id FROM `coach`";

        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
        }
        $stmt->execute();
        return $stmt->fetch();

    }






    public function insert_coach($idCoach)
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "INSERT INTO `user`( `role`, `id_t`) VALUES ('coach','.$idCoach.') ";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }




    public function insert_user($idJoueur)
    {


        $conn = $this->getEntityManager()->getConnection();

        $sql = "INSERT INTO `user`( `role`, `id_t`) VALUES ('joueur','$idJoueur') ";


        $stmt = $conn->prepare($sql);

        $stmt->execute();




        return $stmt;
    }











    public function recupere_information_coach()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "SELECT * FROM `user` u inner join coach c where c.id_coach=u.id_t GROUP BY id_user";

        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
        }
        $stmt->execute();
        return $stmt->fetchAll();


    }


    public function recupere_information_joueur()
    {
        $conn = $this->getEntityManager()->getConnection();
        $sql = "select * FROM `user` u inner join joueur j where j.id_joueur=u.id_t";

        try {
            $stmt = $conn->prepare($sql);
        } catch (Exception $e) {
        }
        $stmt->execute();
        return $stmt->fetchAll();


    }


















}
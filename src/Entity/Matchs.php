<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Matchs
 *
 * @ORM\Table(name="matchs", indexes={@ORM\Index(name="id_equipe1", columns={"id_equipe1"}), @ORM\Index(name="id_stade", columns={"id_stade"}), @ORM\Index(name="id_equipe2", columns={"id_equipe2"}), @ORM\Index(name="id_org", columns={"id_org"})})
 * @ORM\Entity(repositoryClass="App\Repository\MatchsRepository")
 */
class Matchs
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_match", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("matchs")
     */
    private $idMatch;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="date", nullable=false)
     * @Assert\GreaterThanOrEqual("today")
     * @Groups("matchs")
     */
    private $date;

    /**
     * @var string
     *  @Assert\NotNull
     * @Assert\NotBlank
     * @ORM\Column(name="heure_deb", type="string", length=255, nullable=false)
     * @Groups("matchs")
     */
    private $heureDeb;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(name="heure_fin", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Assert\Expression (
     *     "this.getHeureDeb() < this.getHeureFin()",
     *     message="l'heure de fin ne doit pas etre avant l'heure de début"
     * )
     * @Groups("matchs")
     */
    private $heureFin;

    /**
     * @var string
     * @Assert\NotNull
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     * @Assert\NotBlank
     * @Groups("matchs")
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=255, nullable=false)
     *  @Groups("matchs")
     */
    private $status;

    /**
     * @var string|null
     *
     * @ORM\Column(name="score", type="string", length=255, nullable=true)
     * @Groups("matchs")
     */
    private $score;

    /**
     * @var int|null
     * @Assert\NotNull
     * @ORM\Column(name="nb_spectateur", type="integer", nullable=true)
     * @Assert\NotBlank
     *  @Groups("matchs")
     */
    private $nbSpectateur;

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * @Assert\Expression (
     *     "this.getIdEquipe1() != this.getIdEquipe2()",
     *     message=" equipe1 ne doit pas etre equipe2"
     * )
     *
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_equipe1", referencedColumnName="id_e")
     * })
     *  @Groups("matchs")
     */
    private $idEquipe1;

    /**
     * @var \Equipe
     *
     * @ORM\ManyToOne(targetEntity="Equipe")
     * * @Assert\Expression (
     *     "this.getIdEquipe1() != this.getIdEquipe2()",
     *     message=" equipe1 ne doit pas etre equipe2"
     * )
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_equipe2", referencedColumnName="id_e")
     * })
     *  @Groups("matchs")
     */
    private $idEquipe2;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_org", referencedColumnName="id")
     * })
     *  @Groups("matchs")
     */
    private $idOrg;

    /**
     * @var \Stade
     *
     * @ORM\ManyToOne(targetEntity="Stade")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_stade", referencedColumnName="id_stade")
     * })
     *  @Groups("matchs")
     */
    private $idStade;

    /**
     * Get Date
     *
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Get heureDeb
     *
     * @return string
     */
    public function getHeureDeb()
    {
        return $this->heureDeb;
    }


    public function getHeureFin(): ?string
    {
        return $this->heureFin;
    }

    public function getNbSpectateur(): ?int
    {
        return $this->nbSpectateur;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function getIdMatch(): ?int
    {
        return $this->idMatch;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }
    public function getScore(): ?string
    {
        return $this->score;
    }
    /**
     * Get IdEquipe1
     *
     * @return integer
     */
    public function getIdEquipe1()
    {
        return $this->idEquipe1;
    }
    /**
     * Get IdEquipe2
     *
     * @return integer
     */
    public function getIdEquipe2()
    {
        return $this->idEquipe2;
    }
    /**
     * Get IdOrg
     *
     * @return integer
     */
    public function getIdOrg()
    {
        return $this->idOrg;
    }
    /**
     * Get IdStade
     *
     * @return integer
     */
    public function getIdStade()
    {
        return $this->idStade;
    }


    public function setDate(\DateTime $date)
    {
        $this->date = $date;
        return $this;
    }

    /*   public function setIdMatch(int $idMatch)
       {
           $this->idMatch = $idMatch;
           return $this;
       }*/


    public function setHeureDeb(string $heureDeb)
    {
        $this->heureDeb = $heureDeb;
        return $this;
    }


    public function setHeureFin(string $heureFin)
    {
        $this->heureFin = $heureFin;
        return $this;
    }

    public function setNbSpectateur(int $nbSpectateur)
    {
        $this->nbSpectateur = $nbSpectateur;
        return $this;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
        return $this;
    }

    public function setStatus(string $st)
    {
        $this->status = $st;
        return $this;
    }

    public function setScore(string $score)
    {
        $this->score = $score;
        return $this;
    }

    /**
     * Set idEquipe1
     *
     * @param integer $idE
     *
     */
    public function setIdEquipe1($idE)
    {
        $this->idEquipe1 = $idE;
        return $this;
    }


    /**
     * Set idEquipe2
     *
     * @param integer $idE2
     *
     */
    public function setIdEquipe2($idE2)
    {
        $this->idEquipe2 = $idE2;
        return $this;
    }
    /**
     * Set idOrg
     *
     * @param integer $idOrg
     *
     */
    public function setIdOrg($idOrg)
    {
        $this->idOrg = $idOrg;
        return $this;
    }

    /**
     * Set idStade
     *
     * @param integer $idStade
     *
     */
    public function setIdStade($idStade)
    {
        $this->idStade = $idStade;
        return $this;
    }

}

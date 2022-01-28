<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups ;


/**
 * Entrainement
 *
 * @ORM\Table(name="entrainement")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\EntrainementRepository")
 */
class Entrainement
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_entrainement", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("posts:read")
     * @Groups({"entrainements"})

     */
    private $idEntrainement;

    /**
     * @var int
     * @Groups({"entrainements"})
     * @ORM\Column(name="duree", type="integer", nullable=false)
     *

     *  @Assert\Range(
     *      min = 45,
     *      max = 120,
     *      notInRangeMessage = "Duree d'entrainement doit etre entre {{ min }}Minutes  and {{ max }}Minutes ",
     * )
     *  @Groups("posts:read")
     */
    private $duree;

    /**
     * @var \DateTime
     * @Groups({"entrainements"})
     * @ORM\Column(name="date_entrainement", type="date", nullable=false)
     * @Groups("posts:read")

     */
    private $dateEntrainement;

    /**
     * @var string
     * @Groups({"entrainements"})
     * @ORM\Column(name="heure", type="string", length=50, nullable=false)
     *  @Assert\Range(
     *      min = 9,
     *      max = 23,
     *      notInRangeMessage = "l'jeure doit etre compris entre{{ min }}Heure  and {{ max }}Heure ",
     * )
     *  @Groups("posts:read")
     */
    private $heure;

    /**
     * @var int
     * @Groups({"entrainements"})
     * @ORM\Column(name="id_coach", type="integer", nullable=false)
     * @Assert\Positive
     * @Groups("posts:read")

     */
    private $idCoach;

    /**
     * @var int
     * @Groups({"entrainements"})
     * @ORM\Column(name="id_stade", type="integer", nullable=false)
     * @Assert\Positive
     * @Groups("posts:read")
     */
    private $idStade;

    /**
     * @var int
     * @Groups({"entrainements"})
     * @ORM\Column(name="id_equipe", type="integer", nullable=false)
     * @Assert\Positive
     * @Groups("posts:read")

     */
    private $idEquipe;




    /**
     * @var string
     * @Groups({"entrainements"})
     * @ORM\Column(name="Type", type="string", length=255, nullable=false)
     * @Assert\Choice({"Attaque", "Diffence", "Milieu"})
     * @Groups("posts:read")
     */
    private $type;




    protected $captchaCode;

    public function getCaptchaCode()
    {
        return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
        $this->captchaCode = $captchaCode;
    }



    public function getIdEntrainement(): ?int
    {
        return $this->idEntrainement;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDateEntrainement(): ?\DateTimeInterface
    {
        return $this->dateEntrainement;
    }

    public function setDateEntrainement(\DateTimeInterface $dateEntrainement): self
    {
        $this->dateEntrainement = $dateEntrainement;

        return $this;
    }

    public function getHeure(): ?string
    {
        return $this->heure;
    }

    public function setHeure(string $heure): self
    {
        $this->heure = $heure;

        return $this;
    }

    public function getIdCoach(): ?int
    {
        return $this->idCoach;
    }

    public function setIdCoach(int $idCoach): self
    {
        $this->idCoach = $idCoach;

        return $this;
    }

    public function getIdStade(): ?int
    {
        return $this->idStade;
    }

    public function setIdStade(int $idStade): self
    {
        $this->idStade = $idStade;

        return $this;
    }

    public function getIdEquipe(): ?int
    {
        return $this->idEquipe;
    }

    public function setIdEquipe(int $idEquipe): self
    {
        $this->idEquipe = $idEquipe;

        return $this;
    }


    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }





}

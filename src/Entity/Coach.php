<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use commandeBundle\Repository\CoachRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Coach
 * @ORM\Table(name="coach")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\CoachRepository")
 *
 */



class Coach
{




    /**
     * @var int
     * @ORM\Column(name="id_coach", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups({"coachs"})
     */
    private $idCoach;

    /**
     * @var string
     * @Groups({"coachs"})
     * @ORM\Column(name="nom_coach", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="le nom de coach est obligatoire")
     */
    private $nomCoach;




    /**
     * @var string
     * @Groups({"coachs"})
     *
     * @ORM\Column(name="prenom_coach", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="le prenom de coach est obligatoire")

     */
    private $prenomCoach;

    /**
     * @var \DateTime
     * @Groups({"coachs"})
     *
     * @ORM\Column(name="date_naissance", type="date", nullable=false)
     */
    private $dateNaissance;

    /**
     * @var string|null
     * @Groups({"coachs"})
     *
     * @ORM\Column(name="grade", type="string", length=50, nullable=true)
     * @Assert\NotBlank(message="Grade de coach est obligatoire")

     */
    private $grade;

    /**
     * @var \DateTime
     * @Groups({"coachs"})
     *
     * @ORM\Column(name="date_fin_contrat", type="date", nullable=false)
     */
    private $dateFinContrat;

    /**
     * @var string
     * @Groups({"coachs"})
     *
     * @ORM\Column(name="adresse_mail", type="string", length=50, nullable=false)
     * @Assert\Email(
     *  message = "The email '{{ value }}' is not a valid email."
     * )
     */
    private $adresseMail;

    /**
     * @var float
     * @Groups({"coachs"})
     *
     * @ORM\Column(name="salaire", type="float", precision=10, scale=0, nullable=false)
     * @Assert\Range(
     *      min = 1500,
     *      max = 4500,
     *      notInRangeMessage = "Le salaire doit etre entre 1500 DT et 4500 DT",
     * )
     */
    private $salaire;

    /**
     * @var int
     * @Groups({"coachs"})
     *
     * @ORM\Column(name="nb_trophe_locaux", type="integer", nullable=false)
     * @Assert\Positive

     */
    private $nbTropheLocaux;

    /**
     * @var int
     * @Groups({"coachs"})
     *
     * @ORM\Column(name="nb_trophe_internationaux", type="integer", nullable=false)
     * @Assert\Positive

     */
    private $nbTropheInternationaux;

    /**
     * @var string
     * @Groups({"coachs"})
     *
     *
     * @ORM\Column(name="formation_prefere", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Il faut choisir la formation prefere")
     */
    private $formationPrefere;

    /**
     * @var string
     * @Groups({"coachs"})
     *
     * @ORM\Column(name="image_formation", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Il faut selectionner image de formation")

     */
    private $imageFormation;

    /**
     * @var string
     * @Groups({"coachs"})
     *
     * @ORM\Column(name="image_coach", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="Il faut selectionner image de coach")

     */
    private $imageCoach;

    /**
     * @var int
     * @Groups({"coachs"})
     *
     * @ORM\Column(name="age", type="integer", nullable=false)
     * @Assert\Range(
     *      min = 25,
     *      max = 60,
     *      notInRangeMessage = "You must be between {{ min }} ans and {{ max }} ans tall to enter",
     * )
     */
    private $age;

    /**
     * @var string|null
     * @Groups({"coachs"})
     *
     * @ORM\Column(name="mdp_coach", type="string", length=50, nullable=true)
     * @Assert\NotBlank(message="Choisissez un mot de passe")

     */
    private $mdpCoach;

    protected $captchaCode;

    public function getCaptchaCode()
    {
        return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
        $this->captchaCode = $captchaCode;
    }

    public function getIdCoach(): ?int
    {
        return $this->idCoach;
    }

    public function getNomCoach(): ?string
    {
        return $this->nomCoach;
    }

    public function setNomCoach(string $nomCoach): self
    {
        $this->nomCoach = $nomCoach;

        return $this;
    }

    public function getPrenomCoach(): ?string
    {
        return $this->prenomCoach;
    }

    public function setPrenomCoach(string $prenomCoach): self
    {
        $this->prenomCoach = $prenomCoach;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(?string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getDateFinContrat(): ?\DateTimeInterface
    {
        return $this->dateFinContrat;
    }

    public function setDateFinContrat(\DateTimeInterface $dateFinContrat): self
    {
        $this->dateFinContrat = $dateFinContrat;

        return $this;
    }

    public function getAdresseMail(): ?string
    {
        return $this->adresseMail;
    }

    public function setAdresseMail(string $adresseMail): self
    {
        $this->adresseMail = $adresseMail;

        return $this;
    }

    public function getSalaire(): ?float
    {
        return $this->salaire;
    }

    public function setSalaire(float $salaire): self
    {
        $this->salaire = $salaire;

        return $this;
    }

    public function getNbTropheLocaux(): ?int
    {
        return $this->nbTropheLocaux;
    }

    public function setNbTropheLocaux(int $nbTropheLocaux): self
    {
        $this->nbTropheLocaux = $nbTropheLocaux;

        return $this;
    }

    public function getNbTropheInternationaux(): ?int
    {
        return $this->nbTropheInternationaux;
    }

    public function setNbTropheInternationaux(int $nbTropheInternationaux): self
    {
        $this->nbTropheInternationaux = $nbTropheInternationaux;

        return $this;
    }

    public function getFormationPrefere(): ?string
    {
        return $this->formationPrefere;
    }

    public function setFormationPrefere(string $formationPrefere): self
    {
        $this->formationPrefere = $formationPrefere;

        return $this;
    }





    public function getImageFormation()
    {
        return $this->imageFormation;
    }

    public function setImageFormation( $imageFormation)
    {
        $this->imageFormation = $imageFormation;

        return $this;
    }










    public function getImageCoach()
    {
        return $this->imageCoach;
    }



    public function setImageCoach( $imageCoach)
    {
        $this->imageCoach = $imageCoach;

        return $this;
    }













    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(int $age): self
    {
        $this->age = $age;

        return $this;
    }

    public function getMdpCoach(): ?string
    {
        return $this->mdpCoach;
    }

    public function setMdpCoach(?string $mdpCoach): self
    {
        $this->mdpCoach = $mdpCoach;

        return $this;
    }


}

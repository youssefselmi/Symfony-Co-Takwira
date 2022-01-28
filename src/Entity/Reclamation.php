<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups ;

/**
 * reclamation
 *
 * @ORM\Table(name="reclamation")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="App\Repository\ReclamationRepository")
 */
class Reclamation
{
    /**
     * @var int
     *@Groups("reclamation")
     * @ORM\Column(name="idRec", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("posts:read")
     */
    private $idrec;

    /**
     * @var int
     *@Groups("reclamation")
     * @ORM\Column(name="idJoueur", type="integer", nullable=false)
     *  @Groups("posts:read")
     */
    private $idjoueur;

    /**
     * @var string
     *@Groups("reclamation")
     * @ORM\Column(name="SujetRec", type="string", length=75, nullable=false)
     *  @Groups("posts:read")
     */
    private $sujetrec;

    /**
     * @var string
     *@Groups("reclamation")
     * @ORM\Column(name="DescriptionRec", type="string", length=250, nullable=false)
     *  @Groups("posts:read")
     */
    private $descriptionrec;

    /**
     * @var string
     *@Groups("reclamation")
     * @ORM\Column(name="StatusRec", type="string", length=55, nullable=false)
     *  @Groups("posts:read")
     */
    private $statusrec;

    /**
     * @var \DateTime
     *@Groups("reclamation")
     * @ORM\Column(name="DateRec", type="date", nullable=false)
     *  @Groups("posts:read")
     */
    private $daterec;

    /**
     * @var string|null
     *@Groups("reclamation")
     * @ORM\Column(name="DateTraitement", type="string", nullable=true, options={"default"="NULL"})
     *  @Groups("posts:read")
     */
    private $datetraitement = 'NULL';

    /**
     * @var string|null
     *@Groups("reclamation")
     * @ORM\Column(name="NomPrenomCoach", type="string", length=50, nullable=true, options={"default"="NULL"})
     *  @Groups("posts:read")
     */
    private $nomprenomcoach = 'NULL';

    /**
     * @var string
     *@Groups("reclamation")
     * @ORM\Column(name="NomJoueur", type="string", length=255, nullable=false)
     *  @Groups("posts:read")
     */
    private $nomjoueur;

    /**
     * @var string
     *@Groups("reclamation")
     * @ORM\Column(name="PrenomJoueur", type="string", length=255, nullable=false)
     *  @Groups("posts:read")
     */
    private $prenomjoueur;

    /**
     * @var string
     *@Groups("reclamation")
     * @ORM\Column(name="EmailJoueur", type="string", length=255, nullable=false)
     *  @Groups("posts:read")
     */
    private $emailjoueur;

    /**
     * @var string
     *@Groups("reclamation")
     * @ORM\Column(name="TlJoueur", type="string", length=12, nullable=false)
     *  @Groups("posts:read")
     */
    private $tljoueur;

    /**
     * @var string|null
     *@Groups("reclamation")
     * @ORM\Column(name="imgRec", type="string", length=255, nullable=true, options={"default"="NULL"})
     *  @Groups("posts:read")
     */
    private $imgrec = 'NULL';

    /**
     * @var int
     *@Groups("reclamation")
     * @ORM\Column(name="Opened", type="integer", nullable=false)
     *  @Groups("posts:read")
     */
    private $opened = '0';

    public function getIdrec(): ?int
    {
        return $this->idrec;
    }

    public function getIdjoueur(): ?int
    {
        return $this->idjoueur;
    }

    public function setIdjoueur(int $idjoueur): self
    {
        $this->idjoueur = $idjoueur;

        return $this;
    }

    public function getSujetrec(): ?string
    {
        return $this->sujetrec;
    }

    public function setSujetrec(?string $sujetrec): self
    {
        $this->sujetrec = $sujetrec;

        return $this;
    }

    public function getDescriptionrec(): ?string
    {
        return $this->descriptionrec;
    }

    public function setDescriptionrec(?string $descriptionrec): self
    {
        $this->descriptionrec = $descriptionrec;

        return $this;
    }

    public function getStatusrec(): ?string
    {
        return $this->statusrec;
    }

    public function setStatusrec(string $statusrec): self
    {
        $this->statusrec = $statusrec;

        return $this;
    }

    public function getDaterec(): ?\DateTimeInterface
    {
        return $this->daterec;
    }

    public function setDaterec(\DateTimeInterface $daterec): self
    {
        $this->daterec = $daterec;

        return $this;
    }

    public function getDatetraitement(): ?string
    {
        return null;
        if ($this->Datetraitement !== null) {
            return $this->Datetraitement;
        }

    }

    public function setDatetraitement(?string $datetraitement): self
    {
        $this->datetraitement = $datetraitement;

        return $this;
    }

    public function getNomprenomcoach(): ?string
    {
        return $this->nomprenomcoach;
    }

    public function setNomprenomcoach(?string $nomprenomcoach): self
    {
        $this->nomprenomcoach = $nomprenomcoach;

        return $this;
    }

    public function getNomjoueur(): ?string
    {
        return $this->nomjoueur;
    }

    public function setNomjoueur(string $nomjoueur): self
    {
        $this->nomjoueur = $nomjoueur;

        return $this;
    }

    public function getPrenomjoueur(): ?string
    {
        return $this->prenomjoueur;
    }

    public function setPrenomjoueur(string $prenomjoueur): self
    {
        $this->prenomjoueur = $prenomjoueur;

        return $this;
    }

    public function getEmailjoueur(): ?string
    {
        return $this->emailjoueur;
    }

    public function setEmailjoueur(string $emailjoueur): self
    {
        $this->emailjoueur = $emailjoueur;

        return $this;
    }

    public function getTljoueur(): ?string
    {
        return $this->tljoueur;
    }

    public function setTljoueur(string $tljoueur): self
    {
        $this->tljoueur = $tljoueur;

        return $this;
    }

    public function getImgrec()
    {
        return $this->imgrec;
    }

    public function setImgrec( $imgrec)
    {
        $this->imgrec = $imgrec;

        return $this;
    }

    public function getOpened(): ?int
    {
        return $this->opened;
    }

    public function setOpened(int $opened): self
    {
        $this->opened = $opened;

        return $this;
    }


}

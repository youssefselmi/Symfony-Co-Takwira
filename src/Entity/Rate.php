<?php

namespace App\Entity;
use  Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;


/**
 * Rate
 *
 * @ORM\Table(name="rate", indexes={@ORM\Index(name="idCoach", columns={"idCoach"})})
 * @ORM\Entity
 */
class Rate
{
    /**
     * @var int
     *
     * @ORM\Column(name="idRate", type="integer", nullable=false)
     * @ORM\Id
     * @Groups("rate")

     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idrate;

    /**
     * @var int|null
     *@Groups("rate")
     * @ORM\Column(name="idCoach", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $idcoach = NULL;

    /**
     * @var string|null
     *@Groups("rate")
     * @ORM\Column(name="NomPrenomCoach", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $nomprenomcoach = 'NULL';

    /**
     * @var string|null
     *@Groups("rate")
     * @ORM\Column(name="NomEquipe", type="string", length=50, nullable=true, options={"default"="NULL"})
     */
    private $nomequipe = 'NULL';

    /**
     * @var string|null
     *@Groups("rate")
     * @ORM\Column(name="DateRate", type="string", nullable=true, options={"default"="NULL"})
     */
    private $daterate = 'NULL';

    /**
     * @var int|null
     *@Groups("rate")
     * @ORM\Column(name="Rate", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $rate = NULL;

    public function getIdrate(): ?int
    {
        return $this->idrate;
    }

    public function getIdcoach(): ?int
    {
        return $this->idcoach;
    }

    public function setIdcoach(?int $idcoach): self
    {
        $this->idcoach = $idcoach;

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

    public function getNomequipe(): ?string
    {
        return $this->nomequipe;
    }

    public function setNomequipe(?string $nomequipe): self
    {
        $this->nomequipe = $nomequipe;

        return $this;
    }

    public function getDaterate(): ?string
    {
        return $this->daterate;
    }

    public function setDaterate(?string $daterate): self
    {
        $this->daterate = $daterate;

        return $this;
    }

    public function getRate(): ?int
    {
        return $this->rate;
    }

    public function setRate(?int $rate): self
    {
        $this->rate = $rate;

        return $this;
    }



}

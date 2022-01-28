<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use Doctrine\ORM\Mapping as ORM;

/**
 * Equipe
 *
 * @ORM\Table(name="equipe", indexes={@ORM\Index(name="id_coach", columns={"id_coach"})})
 * @ORM\Entity
 */
class Equipe
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_e", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @Groups("equipes")
     */

    private $idE;

    /**
     * @var string
     * @Groups("equipes")
     * @ORM\Column(name="nom_equipe", type="string", length=50, nullable=false)
     */
    private $nomEquipe;

    /**
     * @var \Coach
     * @Groups("coaches")
     * @ORM\ManyToOne(targetEntity="Coach")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_coach", referencedColumnName="id_coach")
     * })
     */
    private $idCoach;






    public function getIdE(): ?int
    {
        return $this->idE;
    }

    /**
     * @param int $idE
     */
    public function setIdE(int $idE): void
    {
        $this->idE = $idE;
    }

    public function getNomEquipe(): ?string
    {
        return $this->nomEquipe;
    }

    public function setNomEquipe(string $nomEquipe): self
    {
        $this->nomEquipe = $nomEquipe;

        return $this;
    }

    public function getIdCoach(): ?Coach
    {
        return $this->idCoach;
    }

    public function setIdCoach(Coach $idCoach): self
    {
        $this->idCoach = $idCoach;

        return $this;
    }

}

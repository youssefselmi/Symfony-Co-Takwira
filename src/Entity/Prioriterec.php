<?php

namespace App\Entity;



use Doctrine\ORM\Mapping as ORM;

/**
 * Prioriterec
 *
 * @ORM\Table(name="prioriterec", indexes={@ORM\Index(name="idRec", columns={"idRec"})})
 * @ORM\Entity
 */
class Prioriterec
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="PrioriteRec", type="string", length=255, nullable=false)
     */
    private $prioriterec;

    /**
     * @var \Reclamation
     *
     * @ORM\ManyToOne(targetEntity="Reclamation")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idRec", referencedColumnName="idRec")
     * })
     */
    private $idrec;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrioriterec(): ?string
    {
        return $this->prioriterec;
    }

    public function setPrioriterec(string $prioriterec): self
    {
        $this->prioriterec = $prioriterec;

        return $this;
    }

    public function getIdrec(): ?Reclamation
    {
        return $this->idrec;
    }

    public function setIdrec(?Reclamation $idrec): self
    {
        $this->idrec = $idrec;

        return $this;
    }


}

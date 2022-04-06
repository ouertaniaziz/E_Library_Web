<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Abonnement
 *
 * @ORM\Table(name="abonnement", indexes={@ORM\Index(name="ID_USER", columns={"ID_USER"}), @ORM\Index(name="ID_OFFRE", columns={"ID_OFFRE"})})
 * @ORM\Entity
 */
class Abonnement
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_ABONNEMENT", type="integer", nullable=false, options={"comment"="IDENTIFIANT UNIQUE DE CHAQUE ABONNEMENT"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAbonnement;

    /**
     * @var int
     *
     * @ORM\Column(name="NBR_JETON_ABONNEMENT", type="integer", nullable=false, options={"comment"="NOMBRE DE JETON NON CONSOMEE PAR LE CLIENT"})
     */
    private $nbrJetonAbonnement;

    /**
     * @var int
     *
     * @ORM\Column(name="SOLDE", type="integer", nullable=false)
     */
    private $solde;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_USER", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @var \Offre
     *
     * @ORM\ManyToOne(targetEntity="Offre")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_OFFRE", referencedColumnName="ID_OFFRE")
     * })
     */
    private $idOffre;

    public function getIdAbonnement(): ?int
    {
        return $this->idAbonnement;
    }

    public function getNbrJetonAbonnement(): ?int
    {
        return $this->nbrJetonAbonnement;
    }

    public function setNbrJetonAbonnement(int $nbrJetonAbonnement): self
    {
        $this->nbrJetonAbonnement = $nbrJetonAbonnement;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }

    public function getIdUser(): ?Users
    {
        return $this->idUser;
    }

    public function setIdUser(?Users $idUser): self
    {
        $this->idUser = $idUser;

        return $this;
    }

    public function getIdOffre(): ?Offre
    {
        return $this->idOffre;
    }

    public function setIdOffre(?Offre $idOffre): self
    {
        $this->idOffre = $idOffre;

        return $this;
    }


}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande", uniqueConstraints={@ORM\UniqueConstraint(name="id_user_2", columns={"id_user"})}, indexes={@ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity
 */
class Commande
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_commande", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idCommande;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_total", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixTotal;

    /**
     * @var int
     *
     * @ORM\Column(name="etat", type="integer", nullable=false)
     */
    private $etat;

    /**
     * @var \Users
     *
     * @ORM\ManyToOne(targetEntity="Users")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id_user")
     * })
     */
    private $idUser;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Ouverage", inversedBy="idCommande")
     * @ORM\JoinTable(name="ligne_panier",
     *   joinColumns={
     *     @ORM\JoinColumn(name="id_commande", referencedColumnName="id_commande")
     *   },
     *   inverseJoinColumns={
     *     @ORM\JoinColumn(name="id_ouvrage", referencedColumnName="id")
     *   }
     * )
     */
    private $idOuvrage;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idOuvrage = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getIdCommande(): ?int
    {
        return $this->idCommande;
    }

    public function getPrixTotal(): ?float
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(float $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getEtat(): ?int
    {
        return $this->etat;
    }

    public function setEtat(int $etat): self
    {
        $this->etat = $etat;

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

    /**
     * @return Collection<int, Ouverage>
     */
    public function getIdOuvrage(): Collection
    {
        return $this->idOuvrage;
    }

    public function addIdOuvrage(Ouverage $idOuvrage): self
    {
        if (!$this->idOuvrage->contains($idOuvrage)) {
            $this->idOuvrage[] = $idOuvrage;
        }

        return $this;
    }

    public function removeIdOuvrage(Ouverage $idOuvrage): self
    {
        $this->idOuvrage->removeElement($idOuvrage);

        return $this;
    }

}

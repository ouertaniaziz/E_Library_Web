<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ouverage
 *
 * @ORM\Table(name="ouverage")
 * @ORM\Entity
 */
class Ouverage
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
     * @ORM\Column(name="Nom_livre", type="string", length=50, nullable=false)
     */
    private $nomLivre;

    /**
     * @var string
     *
     * @ORM\Column(name="genre_livre", type="string", length=50, nullable=false)
     */
    private $genreLivre;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_emprunt", type="integer", nullable=false)
     */
    private $nbrEmprunt;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_vente", type="integer", nullable=false)
     */
    private $nbrVente;

    /**
     * @var int
     *
     * @ORM\Column(name="prix_vente", type="integer", nullable=false)
     */
    private $prixVente;

    /**
     * @var int
     *
     * @ORM\Column(name="prix_emprunt", type="integer", nullable=false)
     */
    private $prixEmprunt;

    /**
     * @var string
     *
     * @ORM\Column(name="img_livre", type="string", length=50, nullable=false)
     */
    private $imgLivre;

    /**
     * @var \Doctrine\Common\Collections\Collection
     *
     * @ORM\ManyToMany(targetEntity="Commande", mappedBy="idOuvrage")
     */
    private $idCommande;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->idCommande = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomLivre(): ?string
    {
        return $this->nomLivre;
    }

    public function setNomLivre(string $nomLivre): self
    {
        $this->nomLivre = $nomLivre;

        return $this;
    }

    public function getGenreLivre(): ?string
    {
        return $this->genreLivre;
    }

    public function setGenreLivre(string $genreLivre): self
    {
        $this->genreLivre = $genreLivre;

        return $this;
    }

    public function getNbrEmprunt(): ?int
    {
        return $this->nbrEmprunt;
    }

    public function setNbrEmprunt(int $nbrEmprunt): self
    {
        $this->nbrEmprunt = $nbrEmprunt;

        return $this;
    }

    public function getNbrVente(): ?int
    {
        return $this->nbrVente;
    }

    public function setNbrVente(int $nbrVente): self
    {
        $this->nbrVente = $nbrVente;

        return $this;
    }

    public function getPrixVente(): ?int
    {
        return $this->prixVente;
    }

    public function setPrixVente(int $prixVente): self
    {
        $this->prixVente = $prixVente;

        return $this;
    }

    public function getPrixEmprunt(): ?int
    {
        return $this->prixEmprunt;
    }

    public function setPrixEmprunt(int $prixEmprunt): self
    {
        $this->prixEmprunt = $prixEmprunt;

        return $this;
    }

    public function getImgLivre(): ?string
    {
        return $this->imgLivre;
    }

    public function setImgLivre(string $imgLivre): self
    {
        $this->imgLivre = $imgLivre;

        return $this;
    }

    /**
     * @return Collection<int, Commande>
     */
    public function getIdCommande(): Collection
    {
        return $this->idCommande;
    }

    public function addIdCommande(Commande $idCommande): self
    {
        if (!$this->idCommande->contains($idCommande)) {
            $this->idCommande[] = $idCommande;
            $idCommande->addIdOuvrage($this);
        }

        return $this;
    }

    public function removeIdCommande(Commande $idCommande): self
    {
        if ($this->idCommande->removeElement($idCommande)) {
            $idCommande->removeIdOuvrage($this);
        }

        return $this;
    }

}

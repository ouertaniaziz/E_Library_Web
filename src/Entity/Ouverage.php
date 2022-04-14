<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Ouverage
 *
 * @ORM\Table(name="ouverage")
 * @ORM\Entity(repositoryClass="App\Repository\OuverageRepository")
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
     * @Assert\NotBlank(message="nom livre obligatoire")
     */
    private $nomLivre;

    /**
     * @var string
     *
     * @ORM\Column(name="genre_livre", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="genre est obligatoire")
     */
    private $genreLivre;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_emprunt", type="integer", nullable=true)
     */
    private $nbrEmprunt;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_vente", type="integer", nullable=true)
     */
    private $nbrVente;

    /**
     * @var int
     *
     * @ORM\Column(name="prix_vente", type="integer", nullable=false)
     * @Assert\NotBlank(message="prix de vente est obligatoir")
     * @Assert\GreaterThan(0, message="doit etre un montant positif")
     */
    private $prixVente;

    /**
     * @var int
     *
     * @ORM\Column(name="prix_emprunt", type="integer", nullable=false)
     * @Assert\NotBlank(message="prix d'emprunt est obligatoir")
     * @Assert\Positive(message="doit etre un montant positif")
     */
    private $prixEmprunt;

    /**
     * @var string
     *
     * @ORM\Column(name="img_livre", type="string", length=50, nullable=true)
     *
     */
    private ?string $imgLivre = null;

    /**
     * @var Collection
     *
     * @ORM\ManyToMany(targetEntity="Commande", mappedBy="idOuvrage")
     */
    private $idCommande;

    /**
     * @ORM\ManyToOne(targetEntity=Auteur::class, inversedBy="ouverages")
     * @ORM\JoinColumn(name="auteur_id", referencedColumnName="ID_auteur")
     */
    private $auteur;

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

    public function getAuteur(): ?Auteur
    {
        return $this->auteur;
    }

    public function setAuteur(?Auteur $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getImagePath(): string
    {
        if ($this->getImgLivre() === null)
        {
            return "/uploads/ouverages_image/unknown_ouverage.jpg";
        }
        return "/uploads/ouverages_image/".$this->imgLivre;
    }

}

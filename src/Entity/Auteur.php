<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Auteur
 *
 * @ORM\Table(name="auteur")
 * @ORM\Entity
 */
class Auteur
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_auteur", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAuteur;

    /**
     * @var string
     *
     * @ORM\Column(name="Nom_auteur", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Nom auteur obligatoir")
     */
    private $nomAuteur;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom_auteur", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="Prenom auteur est obligatoir")
     */
    private $prenomAuteur;

    /**
     * @var string
     *
     * @ORM\Column(name="photo_auteur", type="string", length=50, nullable=true)
     */
    private $photoAuteur;

    /**
     * @ORM\OneToMany(targetEntity=Ouverage::class, mappedBy="auteur")
     */
    private $ouverages;



    public function __construct()
    {
        $this->ouverages = new ArrayCollection();
    }

    public function getIdAuteur(): ?int
    {
        return $this->idAuteur;
    }

    public function getNomAuteur(): ?string
    {
        return $this->nomAuteur;
    }

    public function setNomAuteur(string $nomAuteur): self
    {
        $this->nomAuteur = $nomAuteur;

        return $this;
    }

    public function getPrenomAuteur(): ?string
    {
        return $this->prenomAuteur;
    }

    public function setPrenomAuteur(string $prenomAuteur): self
    {
        $this->prenomAuteur = $prenomAuteur;

        return $this;
    }

    public function getPhotoAuteur(): ?string
    {
        return $this->photoAuteur;
    }

    public function setPhotoAuteur(string $photoAuteur): self
    {
        $this->photoAuteur = $photoAuteur;

        return $this;
    }

    /**
     * @return Collection<int, Ouverage>
     */
    public function getOuverages(): Collection
    {
        return $this->ouverages;
    }

    public function addOuverage(Ouverage $ouverage): self
    {
        if (!$this->ouverages->contains($ouverage)) {
            $this->ouverages[] = $ouverage;
            $ouverage->setAuteur($this);
        }

        return $this;
    }

    public function removeOuverage(Ouverage $ouverage): self
    {
        if ($this->ouverages->removeElement($ouverage)) {
            // set the owning side to null (unless already changed)
            if ($ouverage->getAuteur() === $this) {
                $ouverage->setAuteur(null);
            }
        }

        return $this;
    }

    public function getPhotoPath(): string
    {
        return "/uploads/auteurs_photo/".$this->photoAuteur;
    }


}

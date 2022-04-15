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
 * @ORM\Entity(repositoryClass="App\Repository\AuteurRepository")
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
     * @ORM\Column(name="Nom_auteur", type="string", length=50, nullable=false)
     * @Assert\NotBlank()
     * @Assert\NotNull()
     */
    private string $nomAuteur;

    /**
     * @var string
     *
     * @ORM\Column(name="Prenom_auteur", type="string", length=50, nullable=false)
     * @Assert\NotBlank(message="prenom auteur est obligatoir")
     * @Assert\NotNull()
     */
    private string $prenomAuteur;

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

    /**
     * @return int
     */
    public function getIdAuteur(): int
    {
        return $this->idAuteur;
    }

    /**
     * @param int $idAuteur
     */
    public function setIdAuteur(int $idAuteur): void
    {
        $this->idAuteur = $idAuteur;
    }

    /**
     * @return string
     */
    public function getNomAuteur(): string
    {
        return $this->nomAuteur;
    }

    /**
     * @param ?string $nomAuteur
     */
    public function setNomAuteur(?string $nomAuteur): void
    {
        $this->nomAuteur = $nomAuteur;
    }

    /**
     * @return ?string
     */
    public function getPrenomAuteur(): ?string
    {
        return $this->prenomAuteur;
    }

    /**
     * @param ?string $prenomAuteur
     */
    public function setPrenomAuteur(?string $prenomAuteur): void
    {
        $this->prenomAuteur = $prenomAuteur;
    }

    /**
     * @return string
     */
    public function getPhotoAuteur(): string
    {
        return $this->photoAuteur;
    }

    /**
     * @param string $photoAuteur
     */
    public function setPhotoAuteur(string $photoAuteur): void
    {
        $this->photoAuteur = $photoAuteur;
    }


    /**
     * @return Collection<int, Ouverage>
     */
    public function getOuverages(): Collection
    {
        return $this->ouverages;
    }

    public function addOuverage(?Ouverage $ouverage): self
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
        if ($this->getPhotoAuteur() === null)
        {
            return "/uploads/auteurs_photo/unknown_auteur.jpg";
        }
        return "/uploads/auteurs_photo/".$this->photoAuteur;
    }


}

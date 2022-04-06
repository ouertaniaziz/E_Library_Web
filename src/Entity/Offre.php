<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Offre
 *
 * @ORM\Table(name="offre")
 * @ORM\Entity
 */
class Offre
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_OFFRE", type="integer", nullable=false, options={"comment"="IDENTIFIANT DE L'OFFRE"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOffre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="NOM_OFFRE", type="string", length=50, nullable=true, options={"comment"="NOM DE L'OFFRE"})
     */
    private $nomOffre;

    /**
     * @var int
     *
     * @ORM\Column(name="PRIX_OFFRE", type="integer", nullable=false, options={"comment"="PRIX DE L'OFFRE"})
     */
    private $prixOffre;

    /**
     * @var int
     *
     * @ORM\Column(name="NBR_JETON_OFFRE", type="integer", nullable=false, options={"comment"="NOMBRE DE JETON PAR OFFRE"})
     */
    private $nbrJetonOffre;

    /**
     * @var string|null
     *
     * @ORM\Column(name="IMG_OFFRE", type="string", length=200, nullable=true, options={"comment"="IMAGE DE CHAQUE OFFRE"})
     */
    private $imgOffre;

    public function getIdOffre(): ?int
    {
        return $this->idOffre;
    }

    public function getNomOffre(): ?string
    {
        return $this->nomOffre;
    }

    public function setNomOffre(?string $nomOffre): self
    {
        $this->nomOffre = $nomOffre;

        return $this;
    }

    public function getPrixOffre(): ?int
    {
        return $this->prixOffre;
    }

    public function setPrixOffre(int $prixOffre): self
    {
        $this->prixOffre = $prixOffre;

        return $this;
    }

    public function getNbrJetonOffre(): ?int
    {
        return $this->nbrJetonOffre;
    }

    public function setNbrJetonOffre(int $nbrJetonOffre): self
    {
        $this->nbrJetonOffre = $nbrJetonOffre;

        return $this;
    }

    public function getImgOffre(): ?string
    {
        return $this->imgOffre;
    }

    public function setImgOffre(?string $imgOffre): self
    {
        $this->imgOffre = $imgOffre;

        return $this;
    }


}

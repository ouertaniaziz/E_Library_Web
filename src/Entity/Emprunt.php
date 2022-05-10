<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

/**
 * Emprunt
 *
 * @ORM\Table(name="emprunt", indexes={@ORM\Index(name="ID_OUVRAGE", columns={"ID_OUVRAGE"})})
 * @ORM\Entity
 */
class Emprunt
{
    /**
     * @var int
     *
     * @ORM\Column(name="ID_EMPRUNT", type="integer", nullable=false, options={"comment"="IDENTIFIANT DE L'EMPRUNT"})
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEmprunt;

    /**
     * @var int
     *
     * @ORM\Column(name="ID_ABONNEMENT", type="integer", nullable=false, options={"comment"="IDENTIFIANT DE LE L'ABONNEMENT DE CLIENT"})
     */
    private $idAbonnement;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DATE_EMPRUNT", type="datetime", nullable=true, options={"default"="CURRENT_TIMESTAMP"})
     */
    private $dateEmprunt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="DATE_RETOUR_OUVRAGE", type="datetime", nullable=true, options={"comment"="LE JOUR QUE LE CLIENT RENDRE LE LIVRE"})
     */
    private $dateRetourOuvrage;

    /**
     * @var \Ouverage
     *
     * @ORM\ManyToOne(targetEntity="Ouverage")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ID_OUVRAGE", referencedColumnName="id")
     * })
     */
    private $idOuvrage;

    public function getIdEmprunt(): ?int
    {
        return $this->idEmprunt;
    }

    public function getIdAbonnement(): ?int
    {
        return $this->idAbonnement;
    }

    public function setIdAbonnement(int $idAbonnement): self
    {
        $this->idAbonnement = $idAbonnement;

        return $this;
    }

    public function getDateEmprunt(): ?\DateTimeInterface
    {
        return $this->dateEmprunt;
    }

    public function setDateEmprunt(?\DateTimeInterface $dateEmprunt): self
    {
        $this->dateEmprunt = $dateEmprunt;

        return $this;
    }

    public function getDateRetourOuvrage(): ?\DateTimeInterface
    {
        return $this->dateRetourOuvrage;
    }

    public function setDateRetourOuvrage(?\DateTimeInterface $dateRetourOuvrage): self
    {
        $this->dateRetourOuvrage = $dateRetourOuvrage;

        return $this;
    }

    public function getIdOuvrage(): ?Ouverage
    {
        return $this->idOuvrage;
    }

    public function setIdOuvrage(?Ouverage $idOuvrage): self
    {
        $this->idOuvrage = $idOuvrage;

        return $this;
    }
    public function sendQREMPRUNT(MailerInterface $mailer , $emailddest)
    {

        $email = (new TemplatedEmail())

            ->from('rania.rhaiem@esprit.tn')
            ->to($emailddest)

            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject("Confirmation Emprunt")
            ->htmlTemplate('offre/empruntQrcode.html.twig')
            //   ->text('This is your password :'.$this->code)
            ->embedFromPath('C:\xampp\htdocs\E_Library_Web\src\Controller\qrcode_emprunt.png', 'emprunt')
        ;



        $mailer->send($email);


        // ...
    }

}

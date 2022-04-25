<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Misd\PhoneNumberBundle\Validator\Constraints\PhoneNumber as AssertPhoneNumber;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
/**
 * Users
 *
 * @ORM\Table(name="users", indexes={@ORM\Index(name="role", columns={"role"}), @ORM\Index(name="abonnement", columns={"abonnement"})})
 * @ORM\Entity
 */
class Users
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_user", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUser;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_user", type="string", length=60, nullable=false)
     * @Assert\NotBlank(message="Veuillez Remplir ce champ")
     *  @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "[a-zA-Z]+"
     * )
     */
    private $nomUser;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom_user", type="string", length=60, nullable=false)
     * @Assert\NotBlank(message="Veuillez Remplir ce champ")
     *   @Assert\Regex(
     *     pattern     = "/^[a-z]+$/i",
     *     htmlPattern = "[a-zA-Z]+"
     * )
     */
    private $prenomUser;

    /**
     * @var string
     *
     * @ORM\Column(name="email_user", type="string", length=60, nullable=false)
     * @Assert\NotBlank(message="Veuillez Remplir ce champ")
     * @Assert\Email(message = "The email '{{ value }}' is not a valid
    email.")
     */
    private $emailUser;

    /**
     * @var string
     *
     * @ORM\Column(name="mdp_user", type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="Veuillez Remplir ce champ")
     */
    private $mdpUser;

    /**
     * @var string
     *
     * @ORM\Column(name="tel_user", type="string", length=8, nullable=false)
     * @Assert\NotBlank(message="Veuillez Remplir ce champ")
     * @Assert\Length(min=8)
     *     @Assert\Regex(
     *     pattern     = "/^[0-9]+$/i",
     *     htmlPattern = "[0-9]+"
     * )
     */
    private $telUser;

    /**
     * @var int|null
     *
     * @ORM\Column(name="abonnement", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $abonnement = NULL;

    /**
     * @var string|null
     *
     * @ORM\Column(name="adresse", type="string", length=60, nullable=true)
     * @Assert\NotBlank(message="Veuillez Remplir ce champ")
     */
    private $adresse = NULL;

    /**
     * @var string|null
     *
     * @ORM\Column(name="Code", type="string", length=60, nullable=true, options={"default"="NULL"})
     * @Assert\NotBlank(message="Veuillez Remplir ce champ")
     */
    private $code = NULL;

    /**
     * @var int
     *
     * @ORM\Column(name="Bloquer", type="integer", nullable=false)
     */
    private $bloquer = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="remember", type="integer", nullable=false)
     */
    private $remember = '0';

    /**
     * @var Role
     *
     * @ORM\ManyToOne(targetEntity="Role",cascade={"persist"}))
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="role", referencedColumnName="id")
     * })
     */
    private Role $role;

    public function getIdUser(): ?int
    {
        return $this->idUser;
    }

    public function getNomUser(): ?string
    {
        return $this->nomUser;
    }

    public function setNomUser(string $nomUser): self
    {
        $this->nomUser = $nomUser;

        return $this;
    }

    public function getPrenomUser(): ?string
    {
        return $this->prenomUser;
    }

    public function setPrenomUser(string $prenomUser): self
    {
        $this->prenomUser = $prenomUser;

        return $this;
    }

    public function getEmailUser(): ?string
    {
        return $this->emailUser;
    }

    public function setEmailUser(string $emailUser): self
    {
        $this->emailUser = $emailUser;

        return $this;
    }

    public function getMdpUser(): ?string
    {
        return $this->mdpUser;
    }

    public function setMdpUser(string $mdpUser): self
    {
        $this->mdpUser = $mdpUser;

        return $this;
    }

    public function getTelUser(): ?string
    {
        return $this->telUser;
    }

    public function setTelUser(string $telUser): self
    {
        $this->telUser = $telUser;

        return $this;
    }

    public function getAbonnement(): ?int
    {
        return $this->abonnement;
    }

    public function setAbonnement(?int $abonnement): self
    {
        $this->abonnement = $abonnement;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getBloquer(): ?int
    {
        return $this->bloquer;
    }

    public function setBloquer(int $bloquer): self
    {
        $this->bloquer = $bloquer;

        return $this;
    }

    public function getRemember(): ?int
    {
        return $this->remember;
    }

    public function setRemember(int $remember): self
    {
        $this->remember = $remember;

        return $this;
    }

    public function getRole(): ?Role
    {
        return $this->role;
    }

    public function setRole(?Role $role): self
    {

        $this->role = $role;


        return $this;
    }

    public function sendPassword(MailerInterface $mailer)
    {

        $email = (new TemplatedEmail())
            ->from('rania.rhaiem@esprit.tn')
            ->to('rania.rhaiem99@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject("Compte")
            ->htmlTemplate('login/emailsendPassword.html.twig')
            // ->text('This is your password :'.$this->mdpUser)
            ->context([
                'mdp' => $this->mdpUser
            ])
        ;;
        $mailer->send($email);


        // ...
    }
    public function newPassword(MailerInterface $mailer)
    {

        $email = (new TemplatedEmail())

            ->from('rania.rhaiem@esprit.tn')
            ->to('rania.rhaiem99@gmail.com')
            //->cc('cc@example.com')
            //->bcc('bcc@example.com')
            //->replyTo('fabien@example.com')
            //->priority(Email::PRIORITY_HIGH)
            ->subject("Récuperer Votre Mot de Passe")
            ->htmlTemplate('login/emailnewPassword.html.twig')
            //   ->text('This is your password :'.$this->code)
            ->context([
                'Code' => $this->code
            ])
        ;



        $mailer->send($email);


        // ...
    }

}

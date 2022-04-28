<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idUser;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $emailUser;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */

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
     * @ORM\Column(name="mdp_user", type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="Veuillez Remplir ce champ")
     */
    private $mdpUser;

    public function getId(): ?int
    {
        return $this->idUser;
    }

    public function getEmail(): ?string
    {
        return $this->emailUser;
    }

    public function setEmail(?string $emailUser): self
    {
        $this->emailUser = $emailUser;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->emailUser;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return $this->mdpUser;
    }

    public function setPassword(string $password): self
    {
        $this->mdpUser = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @return string
     */
    public function getNomUser(): string
    {
        return $this->nomUser;
    }

    /**
     * @param string $nomUser
     */
    public function setNomUser(string $nomUser): void
    {
        $this->nomUser = $nomUser;
    }

    /**
     * @return string
     */
    public function getPrenomUser(): string
    {
        return $this->prenomUser;
    }

    /**
     * @param string $prenomUser
     */
    public function setPrenomUser(string $prenomUser): void
    {
        $this->prenomUser = $prenomUser;
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

    public function getAvatarUrl(int $size = null): string
    {
        $url = 'https://robohash.org/'.$this->getEmail();

        if ($size) {
            $url .= sprintf('?size=%dx%d', $size, $size);
        }

        return $url;
    }

}

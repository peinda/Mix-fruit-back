<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ApiResource(
 * attributes={"access_control"="is_granted('ROLE_ADMIN')"},
 * normalizationContext={"groups"={"user:read"}},
 * denormalizationContext={"groups"={"user:write"}},
 * collectionOperations={
 *      "get"={"access_control"="is_granted('ROLE_ADMIN')"},
 *      "post"={"method"="POST", "access_control"="is_granted('IS_AUTHENTICATED_FULLY') === false"}
 * },
 * itemOperations={
 *      "getUserId"={
 *              "method"="GET",
 *              "path"="/users/{id}",
 *     "access_control"="is_granted('ROLE_ADMIN') or object == user"},
 *      "put"={"access_control"="is_granted('ROLE_ADMIN') or object == user"},
 *      "delete"={"access_control"="is_granted('ROLE_ADMIN')"}
 * },
 * )
 * @UniqueEntity(
 *     fields={"username", "tel"},
 *     message="username ou Telephone existe deja"
 * )
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"user:read", "commenteire:read", "prduit:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"user:read"})
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     * 
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Groups({"user:write"})
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write", "commenteire:read", "prduit:read"})
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write", "commenteire:read", "prduit:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"user:read", "user:write", "commenteire:read", "prduit:read"})
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"user:read", "user:write", "commenteire:read", "prduit:read"})
     */
    private $adress;

    /**
     * @ORM\ManyToOne(targetEntity=Profil::class)
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"user:read"})
     */
    private $profil;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $statut = true;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_'.$this->profil->getLibelle();
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTel(): ?string
    {
        return $this->tel;
    }

    public function setTel(string $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getAdress(): ?string
    {
        return $this->adress;
    }

    public function setAdress(string $adress): self
    {
        $this->adress = $adress;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        if ($this->profil != $profil) {
            $this->profil = $profil;
        }

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(?bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }
}
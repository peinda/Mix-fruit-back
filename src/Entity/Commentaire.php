<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CommentaireRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\DateTime;
// use Symfony\Component\Validator\Constraints\DateTime;

/**
 * @ORM\Entity(repositoryClass=CommentaireRepository::class)
 * @ApiResource(
 * mercure=true,
 * attributes={"access_control"="is_granted('ROLE_ADMIN')"},
 * normalizationContext={"groups"={"commenteire:read"}},
 * denormalizationContext={"groups"={"commenteire:write"}},
 * collectionOperations={
 *      "get",
 *      "post"
 * },
 * itemOperations={
 *      "get",
 *      "delete"={"access_control"="is_granted('ROLE_ADMIN')"}
 * },
 * )
 */
class Commentaire
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     *  @Groups({"commenteire:read", "prduit:read"})
     * 
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Groups({"commenteire:read", "commenteire:write", "prduit:read"})
     */
    private $contenu;

    /**
     * @ORM\Column(type="date")
     * @Groups({"commenteire:read", "prduit:read"})
     */
    private $date ;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @Groups({"commenteire:read", "prduit:read"})
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="commentaires")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"commenteire:read"})
     */
    private $produit;

    public function __construct()
    {
        if (!$this->date) {
            $this->date = new \DateTime();
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(): self
    {
        if (!$this->date) {
            $this->date = new \DateTime();
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getProduit(): ?Produit
    {
        return $this->produit;
    }

    public function setProduit(?Produit $produit): self
    {
        $this->produit = $produit;

        return $this;
    }
}
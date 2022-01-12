<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProduitRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 * @ApiResource(
 * attributes={"access_control"="is_granted('ROLE_ADMIN')"},
 * normalizationContext={"groups"={"prduit:read"}},
 * denormalizationContext={"groups"={"prduit:write"}},
 * collectionOperations={
 *      "get"={"method"="GET", "access_control"="is_granted('IS_AUTHENTICATED_FULLY') === false"},
 *      "post"={"access_control"="is_granted('ROLE_ADMIN')"}
 * },
 * itemOperations={
 *      "get"={"method"="GET", "access_control"="is_granted('IS_AUTHENTICATED_FULLY') === false"},
 *      "put"={"access_control"="is_granted('ROLE_ADMIN')"},
 *      "delete"={"access_control"="is_granted('ROLE_ADMIN')"}
 * },
 * )
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"commenteire:read", "catalogue:read", "prduit:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"commenteire:read", "catalogue:read", "catalogue:write", "prduit:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="float")
     * @Groups({"commenteire:read", "catalogue:read", "catalogue:write", "prduit:read"})
     */
    private $prix;

    /**
     * @ORM\Column(type="boolean")
     *  @Groups({"prduit:read"})
     */
    private $etat_new = true;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"prduit:read"})
     */
    private $statut = false;

    /**
     * @ORM\ManyToOne(targetEntity=Catalogue::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"prduit:read"})
     */
    private $catalogue;

    /**
     * @ORM\OneToMany(targetEntity=Commentaire::class, mappedBy="produit")
     * @Groups({"prduit:read"})
     */
    private $commentaires;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="produit", cascade={"persist"})
     * @Groups({"commenteire:read", "catalogue:read", "catalogue:write", "prduit:write", "prduit:read"})
     */
    private $photos;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="produits")
     */
    private $commande;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->detailCommandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getEtatNew(): ?bool
    {
        return $this->etat_new;
    }

    public function setEtatNew(bool $etat_new): self
    {
        $this->etat_new = $etat_new;

        return $this;
    }

    public function getStatut(): ?bool
    {
        return $this->statut;
    }

    public function setStatut(bool $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getCatalogue(): ?Catalogue
    {
        return $this->catalogue;
    }

    public function setCatalogue(?Catalogue $catalogue): self
    {
        $this->catalogue = $catalogue;

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setProduit($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getProduit() === $this) {
                $commentaire->setProduit(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): self
    {
        if (!$this->photos->contains($photo)) {
            $this->photos[] = $photo;
            $photo->setProduit($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): self
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getProduit() === $this) {
                $photo->setProduit(null);
            }
        }

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

}
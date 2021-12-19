<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\CatalogueRepository;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=CatalogueRepository::class)
 * @ApiResource(
 * attributes={"access_control"="is_granted('ROLE_ADMIN')"},
 * normalizationContext={"groups"={"catalogue:read"}},
 * denormalizationContext={"groups"={"catalogue:write"}},
 * collectionOperations={
 *      "get"={"method"="GET", "access_control"="is_granted('IS_AUTHENTICATED_FULLY') === false"},
 *      "post"={"access_control"="is_granted('ROLE_ADMIN')"}
 * },
 * itemOperations={
 *      "get"={"method"="GET", "access_control"="is_granted('IS_AUTHENTICATED_FULLY') === false"},
 *      "put"={"access_control"="is_granted('ROLE_ADMIN')"},
 *      "delete"={"access_control"="is_granted('ROLE_ADMIN')"},
  *      "getItemid"={"method"="GET","access_control"="is_granted('IS_AUTHENTICATED_FULLY') === false", "path"="/catalogues/{id}/produits", "normalization_context"={"groups"={"normgrp_red"}}}
 * },
 * )
 */
class Catalogue
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"catalogue:read", "prduit:read"})
     * @Groups({"normgrp_red"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"catalogue:read", "catalogue:write", "prduit:read"})
     */
    private $nom;

    /**
     * @ORM\Column(type="date")
     * @Groups({"catalogue:read", "catalogue:write"})
     */
    private $date_creation;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="catalogue", cascade={"persist"})
     * @Groups({"catalogue:read", "catalogue:write"})
     * @Groups({"normgrp_red"})
     */
    private $produits;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"catalogue:read", "catalogue:write", "prduit:read"})
     */
    private $description;

    /**
     * @ORM\Column(type="boolean")
     * @Groups({"catalogue:read", "prduit:read"})
     */
    private $etat=false;

    public function __construct()
    {
        if (!$this->date_creation) {
            $this->date_creation = new \DateTime();
        }
        $this->produits = new ArrayCollection();
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

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->date_creation;
    }

    public function setDateCreation(): self
    {
        if (!$this->date_creation) {
            $this->date_creation = new \DateTime();
        }

        return $this;
    }

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setCatalogue($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCatalogue() === $this) {
                $produit->setCatalogue(null);
            }
        }

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getEtat(): ?bool
    {
        return $this->etat;
    }

    public function setEtat(bool $etat): self
    {
        $this->etat = $etat;

        return $this;
    }
}
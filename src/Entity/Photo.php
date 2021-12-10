<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\PhotoRepository;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 */
class Photo
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"commenteire:read", "catalogue:read", "prduit:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="blob", nullable=true)
     * @Groups({"commenteire:read", "catalogue:read", "catalogue:write", "prduit:write", "prduit:read"})
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="photos")
     * @ORM\JoinColumn(nullable=false)
     */
    private $produit;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage()
    {
        return $this->image!=null? (stream_get_contents($this->image)):null;
    }

    public function setImage($image): self
    {
        $this->image = $image;

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
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\DetailsCommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=DetailsCommandeRepository::class)
 */
class DetailsCommande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     *  @Groups({"comm_write"})
     */
    private $Montant;

    /**
     * @ORM\Column(type="float")
     *  @Groups({"comm_write"})
     */
    private $Total;

    /**
     * @ORM\Column(type="string", length=255)
     *  @Groups({"comm_write"})
     */
    private $QuantiteProduit;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $DateLivraison;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="details")
     */
    private $commande;

    /**
     * @ORM\ManyToOne(targetEntity=Produit::class, inversedBy="detailsCommande")
     */
    private $produit;


    public function __construct()
    {
        $this->commandes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->Montant;
    }

    public function setMontant(float $Montant): self
    {
        $this->Montant = $Montant;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->Total;
    }

    public function setTotal(float $Total): self
    {
        $this->Total = $Total;

        return $this;
    }

    public function getQuantiteProduit(): ?string
    {
        return $this->QuantiteProduit;
    }

    public function setQuantiteProduit(string $QuantiteProduit): self
    {
        $this->QuantiteProduit = $QuantiteProduit;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->DateLivraison;
    }

    public function setDateLivraison(?\DateTimeInterface $DateLivraison): self
    {
        $this->DateLivraison = $DateLivraison;

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

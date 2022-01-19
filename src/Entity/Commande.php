<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 * @ApiResource(
 *      attributes={"denormalization_context"={"groups"={"comm_write"}}
 *           },
 *     collectionOperations={
 *          "Comm"={
 *              "method"="POST",
 *              "path"="/commandes",
 *              "denormalization_context"={"groups"={"command_write"}}
 * } ,
 *              "getComm"={
 *              "method"="GET",
 *              "path"="/commandes",
 *     },
 * }
 * )
 */
class Commande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $prixTotal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;
    
    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=EtatCommande::class, cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $etat;


    /**
     * @ORM\Column(type="date")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $num_commande;

    /**
     * @ORM\OneToMany(targetEntity=DetailsCommande::class, mappedBy="commande")
     */
    private $details;

    public function __construct()
    {
        $this->details = new ArrayCollection();
    }

  


    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrixTotal(): ?float
    {
        return $this->prixTotal;
    }

    public function setPrixTotal(float $prixTotal): self
    {
        $this->prixTotal = $prixTotal;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getEtat(): ?EtatCommande
    {
        return $this->etat;
    }

    public function setEtat(?EtatCommande $etat): self
    {
        $this->etat = $etat;

        return $this;
    }


    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getNumCommande(): ?string
    {
        return $this->num_commande;
    }

    public function setNumCommande(string $num_commande): self
    {
        $this->num_commande = $num_commande;

        return $this;
    }

    /**
     * @return Collection|DetailsCommande[]
     */
    public function getDetails(): Collection
    {
        return $this->details;
    }

    public function addDetail(DetailsCommande $detail): self
    {
        if (!$this->details->contains($detail)) {
            $this->details[] = $detail;
            $detail->setCommande($this);
        }

        return $this;
    }

    public function removeDetail(DetailsCommande $detail): self
    {
        if ($this->details->removeElement($detail)) {
            // set the owning side to null (unless already changed)
            if ($detail->getCommande() === $this) {
                $detail->setCommande(null);
            }
        }

        return $this;
    }

   
}

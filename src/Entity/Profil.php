<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ProfilRepository;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ProfilRepository::class)
 * @ApiResource(
 * attributes={"access_control"="is_granted('ROLE_ADMIN')"},
 * normalizationContext={"groups"={"profile_user:read"}},
 * denormalizationContext={"groups"={"profile_user:write"}},
 * collectionOperations={
 *      "get"={"access_control"="is_granted('ROLE_ADMIN')"},
 *      "post"={"access_control"="is_granted('ROLE_ADMIN')"}
 * },
 * itemOperations={
 *      "get"={"access_control"="is_granted('ROLE_ADMIN')"},
 *      "put"={"access_control"="is_granted('ROLE_ADMIN')"},
 *      "delete"={"access_control"="is_granted('ROLE_ADMIN')"}
 * },
 * )
 * @UniqueEntity(
 *     fields={"libelle"},
 *     message="libelle de ce  Profile existe"
 * )
 */
class Profil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"profile_user:read", "user:read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, unique=true)
     * @Groups({"profile_user:read", "profile_user:write", "user:read"})
     */
    private $libelle;

    /**
     * @ORM\Column(type="boolean")
     */
    private $etat = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

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
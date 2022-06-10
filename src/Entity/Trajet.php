<?php

namespace App\Entity;

use App\Repository\TrajetRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrajetRepository::class)
 */
class Trajet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $conducteur;

    /**
     * @ORM\ManyToOne(targetEntity=LieuTp::class, inversedBy="trajets")
     * @ORM\JoinColumn(name="lieu_tp_id",referencedColumnName="id", onDelete="SET NULL") //Pour mettre à null la relation si c'est supprimé
     */
    private $lieuTp;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="trajets")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $kilometrage;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConducteur(): ?string
    {
        return $this->conducteur;
    }

    public function setConducteur(?string $conducteur): self
    {
        $this->conducteur = $conducteur;

        return $this;
    }

    public function getLieuTp(): ?LieuTp
    {
        return $this->lieuTp;
    }

    public function setLieuTp(?LieuTp $lieuTp): self
    {
        $this->lieuTp = $lieuTp;

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

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getKilometrage(): ?float
    {
        return $this->kilometrage;
    }

    public function setKilometrage(?float $kilometrage): self
    {
        $this->kilometrage = $kilometrage;

        return $this;
    }
}

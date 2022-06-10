<?php

namespace App\Entity;

use App\Repository\LieuTpRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LieuTpRepository::class)
 */
class LieuTp
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $AdresseDepart;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $AdresseArriver;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $kilometrage;

    /**
     * @ORM\OneToMany(targetEntity=Trajet::class, mappedBy="lieuTp" )
     */
    private $trajets;

    public function __construct()
    {
        $this->trajets = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresseDepart(): ?string
    {
        return $this->AdresseDepart;
    }

    public function setAdresseDepart(string $AdresseDepart): self
    {
        $this->AdresseDepart = $AdresseDepart;

        return $this;
    }

    public function getAdresseArriver(): ?string
    {
        return $this->AdresseArriver;
    }

    public function setAdresseArriver(string $AdresseArriver): self
    {
        $this->AdresseArriver = $AdresseArriver;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

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

    /**
     * @return Collection<int, Trajet>
     */
    public function getTrajets(): Collection
    {
        return $this->trajets;
    }

    public function addTrajet(Trajet $trajet): self
    {
        if (!$this->trajets->contains($trajet)) {
            $this->trajets[] = $trajet;
            $trajet->setLieuTp($this);
        }

        return $this;
    }

    public function removeTrajet(Trajet $trajet): self
    {
        if ($this->trajets->removeElement($trajet)) {
            // set the owning side to null (unless already changed)
            if ($trajet->getLieuTp() === $this) {
                $trajet->setLieuTp(null);
            }
        }

        return $this;
    }
}

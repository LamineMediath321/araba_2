<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\SalleExpositionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: SalleExpositionRepository::class)]
class SalleExposition
{
    use Timestampable;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $nomSalle;

    #[ORM\Column(type: 'text')]
    private $description;

    #[ORM\ManyToOne(targetEntity: SousCategorie::class, inversedBy: 'salleExpositions')]
    private $domaine;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $imageName;

    #[ORM\OneToOne(targetEntity: User::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $owner;

    #[ORM\OneToOne(mappedBy: 'salle', cascade: ['persist', 'remove'])]
    private ?AdresseSalle $adresseSalle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomSalle(): ?string
    {
        return $this->nomSalle;
    }

    public function setNomSalle(string $nomSalle): self
    {
        $this->nomSalle = $nomSalle;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDomaine(): ?SousCategorie
    {
        return $this->domaine;
    }

    public function setDomaine(?SousCategorie $domaine): self
    {
        $this->domaine = $domaine;

        return $this;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): self
    {
        $this->imageName = $imageName;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;

        return $this;
    }

    public function getAdresseSalle(): ?AdresseSalle
    {
        return $this->adresseSalle;
    }

    public function setAdresseSalle(?AdresseSalle $adresseSalle): self
    {
        // unset the owning side of the relation if necessary
        if ($adresseSalle === null && $this->adresseSalle !== null) {
            $this->adresseSalle->setSalle(null);
        }

        // set the owning side of the relation if necessary
        if ($adresseSalle !== null && $adresseSalle->getSalle() !== $this) {
            $adresseSalle->setSalle($this);
        }

        $this->adresseSalle = $adresseSalle;

        return $this;
    }
}

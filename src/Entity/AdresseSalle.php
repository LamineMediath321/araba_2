<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\AdresseSalleRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: AdresseSalleRepository::class)]
class AdresseSalle
{
    use Timestampable;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $pays = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $details = null;

    #[ORM\OneToOne(inversedBy: 'adresseSalle', cascade: ['persist', 'remove'])]
    private ?SalleExposition $salle = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getDetails(): ?string
    {
        return $this->details;
    }

    public function setDetails(?string $details): self
    {
        $this->details = $details;

        return $this;
    }

    public function getSalle(): ?SalleExposition
    {
        return $this->salle;
    }

    public function setSalle(?SalleExposition $salle): self
    {
        $this->salle = $salle;

        return $this;
    }
}

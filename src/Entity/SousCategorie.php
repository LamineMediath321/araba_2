<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SousCategorieRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\Unique;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[UniqueEntity('slug')]
#[ORM\Entity(repositoryClass: SousCategorieRepository::class)]
class SousCategorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelle;

    #[ORM\ManyToOne(targetEntity: Categorie::class, inversedBy: 'sousCategories')]
    #[ORM\JoinColumn(nullable: false)]
    private $categorie;

    #[ORM\OneToMany(mappedBy: 'sousCategorie', targetEntity: Annonce::class)]
    private $annonces;

    #[ORM\OneToMany(mappedBy: 'domaine', targetEntity: SalleExposition::class)]
    private $salleExpositions;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    public function __construct()
    {
        $this->annonces = new ArrayCollection();
        $this->salleExpositions = new ArrayCollection();
    }

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

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection<int, Annonce>
     */
    public function getAnnonces(): Collection
    {
        return $this->annonces;
    }

    public function addAnnonce(Annonce $annonce): self
    {
        if (!$this->annonces->contains($annonce)) {
            $this->annonces[] = $annonce;
            $annonce->setSousCategorie($this);
        }

        return $this;
    }

    public function removeAnnonce(Annonce $annonce): self
    {
        if ($this->annonces->removeElement($annonce)) {
            // set the owning side to null (unless already changed)
            if ($annonce->getSousCategorie() === $this) {
                $annonce->setSousCategorie(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SalleExposition>
     */
    public function getSalleExpositions(): Collection
    {
        return $this->salleExpositions;
    }

    public function addSalleExposition(SalleExposition $salleExposition): self
    {
        if (!$this->salleExpositions->contains($salleExposition)) {
            $this->salleExpositions[] = $salleExposition;
            $salleExposition->setDomaine($this);
        }

        return $this;
    }

    public function removeSalleExposition(SalleExposition $salleExposition): self
    {
        if ($this->salleExpositions->removeElement($salleExposition)) {
            // set the owning side to null (unless already changed)
            if ($salleExposition->getDomaine() === $this) {
                $salleExposition->setDomaine(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function __toString(): string
    {
        return $this->libelle;
    }

    public function computeSlug(SluggerInterface $slugger)
    {
        if (!$this->slug || '-' === $this->slug) {
            $this->slug = (string) $slugger->slug((string) $this)->lower();
        }
    }
}

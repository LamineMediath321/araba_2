<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Traits\Timestampable;
use App\Repository\AnnonceRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\String\Slugger\SluggerInterface;

#[UniqueEntity('slug')]
#[ORM\Entity(repositoryClass: AnnonceRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Annonce
{
    use Timestampable;
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $libelleAnnonce;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $prix;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: SousCategorie::class, inversedBy: 'annonces')]
    #[ORM\JoinColumn(nullable: false)]
    private $sousCategorie;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lienVideo;

    #[ORM\OneToMany(mappedBy: 'annonce', targetEntity: Commentaire::class, orphanRemoval: true)]
    private $commentaires;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: ImageAnnonce::class, orphanRemoval: true)]
    private $imageAnnonces;

    #[ORM\Column(options: ['default' => true])]
    private ?bool $isUptodate = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $isPaye = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $isCime = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $isVendu = null;

    #[ORM\OneToOne(mappedBy: 'annonce', cascade: ['persist', 'remove'])]
    private ?AdresseAnnonce $adresseAnnonce = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $isPro = null;

    #[ORM\Column(type: Types::BIGINT, options: ['default' => 0])]
    private ?string $nbVus = null;



    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
        $this->imageAnnonces = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleAnnonce(): ?string
    {
        return $this->libelleAnnonce;
    }

    public function setLibelleAnnonce(string $libelleAnnonce): self
    {
        $this->libelleAnnonce = $libelleAnnonce;

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

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): self
    {
        $this->prix = $prix;

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

    public function getSousCategorie(): ?SousCategorie
    {
        return $this->sousCategorie;
    }

    public function setSousCategorie(?SousCategorie $sousCategorie): self
    {
        $this->sousCategorie = $sousCategorie;

        return $this;
    }

    public function getLienVideo(): ?string
    {
        return $this->lienVideo;
    }

    public function setLienVideo(?string $lienVideo): self
    {
        $this->lienVideo = $lienVideo;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setAnnonce($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getAnnonce() === $this) {
                $commentaire->setAnnonce(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ImageAnnonce>
     */
    public function getImageAnnonces(): Collection
    {
        return $this->imageAnnonces;
    }

    public function addImageAnnonce(ImageAnnonce $imageAnnonce): self
    {
        if (!$this->imageAnnonces->contains($imageAnnonce)) {
            $this->imageAnnonces[] = $imageAnnonce;
            $imageAnnonce->setArticle($this);
        }

        return $this;
    }

    public function removeImageAnnonce(ImageAnnonce $imageAnnonce): self
    {
        if ($this->imageAnnonces->removeElement($imageAnnonce)) {
            // set the owning side to null (unless already changed)
            if ($imageAnnonce->getArticle() === $this) {
                $imageAnnonce->setArticle(null);
            }
        }

        return $this;
    }

    public function isIsUptodate(): ?bool
    {
        return $this->isUptodate;
    }

    public function setIsUptodate(bool $isUptodate): self
    {
        $this->isUptodate = $isUptodate;

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

    public function isIsPaye(): ?bool
    {
        return $this->isPaye;
    }

    public function setIsPaye(bool $isPaye): self
    {
        $this->isPaye = $isPaye;

        return $this;
    }

    public function isIsCime(): ?bool
    {
        return $this->isCime;
    }

    public function setIsCime(bool $isCime): self
    {
        $this->isCime = $isCime;

        return $this;
    }


    public function isIsVendu(): ?bool
    {
        return $this->isVendu;
    }

    public function setIsVendu(bool $isVendu): self
    {
        $this->isVendu = $isVendu;

        return $this;
    }

    public function getAdresseAnnonce(): ?AdresseAnnonce
    {
        return $this->adresseAnnonce;
    }

    public function setAdresseAnnonce(?AdresseAnnonce $adresseAnnonce): self
    {
        // unset the owning side of the relation if necessary
        if ($adresseAnnonce === null && $this->adresseAnnonce !== null) {
            $this->adresseAnnonce->setAnnonce(null);
        }

        // set the owning side of the relation if necessary
        if ($adresseAnnonce !== null && $adresseAnnonce->getAnnonce() !== $this) {
            $adresseAnnonce->setAnnonce($this);
        }

        $this->adresseAnnonce = $adresseAnnonce;

        return $this;
    }

    public function isIsPro(): ?bool
    {
        return $this->isPro;
    }

    public function setIsPro(bool $isPro): self
    {
        $this->isPro = $isPro;

        return $this;
    }

    public function getNbVus(): ?string
    {
        return $this->nbVus;
    }

    public function setNbVus(string $nbVus): self
    {
        $this->nbVus = $nbVus;

        return $this;
    }

    public function __toString(): string
    {
        return $this->libelleAnnonce . '-' . (string)$this->createdAt->format('Y-m-d H:i:s');
    }

    public function computeSlug(SluggerInterface $slugger)
    {
        if (!$this->slug || '-' === $this->slug) {
            $this->slug = (string) $slugger->slug((string) $this)->lower();
        }
    }

    #[ORM\PrePersist]
    public function enregistrer()
    {

        if ($this->getCreatedAt() === null) {
            $this->nbVus = 0;
        }
    }
}

<?php

namespace App\Entity;

use App\Entity\Traits\Timestampable;
use App\Repository\SalleExpositionRepository;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @Vich\Uploadable
 */
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

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * 
     * @Vich\UploadableField(mapping="boutique_image", fileNameProperty="imageName")
     * 
     * @var File|null
     */
    private $imageFile;

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

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->setUpdatedAt(new \DateTimeImmutable);
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }


    public function __toString(): string
    {
        return $this->nomSalle;
    }
}

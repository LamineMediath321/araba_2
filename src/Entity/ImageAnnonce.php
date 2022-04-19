<?php

namespace App\Entity;

use App\Repository\ImageAnnonceRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageAnnonceRepository::class)]
class ImageAnnonce
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $imageName;

    #[ORM\ManyToOne(targetEntity: Annonce::class, inversedBy: 'imageAnnonces')]
    #[ORM\JoinColumn(nullable: false)]
    private $article;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getArticle(): ?Annonce
    {
        return $this->article;
    }

    public function setArticle(?Annonce $article): self
    {
        $this->article = $article;

        return $this;
    }
}

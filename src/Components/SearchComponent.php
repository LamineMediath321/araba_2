<?php

// src/Components/ProductSearchComponent.php
namespace App\Components;

use App\Repository\AnnonceRepository;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\Attribute\LiveProp;

#[AsLiveComponent('annonce_search')]
class SearchComponent
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $query = '';

    public function __construct(private AnnonceRepository $annonceRepository)
    {
    }

    public function getAnnonces(): array
    {
        // example method that returns an array of Products
        return $this->annonceRepository->search($this->query);
    }
}

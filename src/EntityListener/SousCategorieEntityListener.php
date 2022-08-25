<?php

namespace App\EntityListener;

use App\Entity\SousCategorie;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class SousCategorieEntityListener
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(SousCategorie $sousCategorie, LifecycleEventArgs $event)
    {
        $sousCategorie->computeSlug($this->slugger);
    }

    public function preUpdate(SousCategorie $sousCategorie, LifecycleEventArgs $event)
    {
        $sousCategorie->computeSlug($this->slugger);
    }
}

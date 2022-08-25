<?php

namespace App\EntityListener;

use App\Entity\Annonce;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class AnnonceEntityListener
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(Annonce $annonce, LifecycleEventArgs $event)
    {
        $annonce->computeSlug($this->slugger);
    }

    public function preUpdate(Annonce $annonce, LifecycleEventArgs $event)
    {
        $annonce->computeSlug($this->slugger);
    }
}

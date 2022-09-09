<?php

namespace App\EntityListener;

use App\Entity\SalleExposition;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Symfony\Component\String\Slugger\SluggerInterface;

class SalleExpositionEntityListener
{
    private $slugger;

    public function __construct(SluggerInterface $slugger)
    {
        $this->slugger = $slugger;
    }

    public function prePersist(SalleExposition $boutique, LifecycleEventArgs $event)
    {
        $boutique->computeSlug($this->slugger);
    }

    public function preUpdate(SalleExposition $boutique, LifecycleEventArgs $event)
    {
        $boutique->computeSlug($this->slugger);
    }
}

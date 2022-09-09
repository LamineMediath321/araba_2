<?php
// src/Components/AlertComponent.php
namespace App\Components;

use App\Entity\SalleExposition;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('boutique.component')]
class BoutiqueInfoComponent
{
    public SalleExposition $boutique;
}

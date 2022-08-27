<?php
// src/Components/AlertComponent.php
namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('annonces')]
class AnnonceComponent
{
    public string $toggle;
    public array  $annonces;
}

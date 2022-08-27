<?php
// src/Components/AlertComponent.php
namespace App\Components;

use App\Entity\Annonce;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('modal')]
class ModalComponent
{
    public Annonce $annonce;
}

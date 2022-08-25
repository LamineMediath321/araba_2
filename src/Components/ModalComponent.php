<?php
// src/Components/AlertComponent.php
namespace App\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('modal')]
class ModalComponent
{
    public int $id;

    public string $libelle;

    public string $description;
}

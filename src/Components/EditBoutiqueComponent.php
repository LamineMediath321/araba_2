<?php

namespace App\Components;

use App\Entity\SalleExposition;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Test\FormInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;
use Symfony\UX\LiveComponent\ValidatableComponentTrait;

#[AsLiveComponent('edit_boutique')]
final class EditBoutiqueComponent extends AbstractController
{
    use DefaultActionTrait;

    use ValidatableComponentTrait;

    #[LiveProp(exposed: ['nomSalle', 'description', 'imageName'])]
    #[Assert\Valid]
    public SalleExposition $boutique;

    public bool $isSaved = false;

    public FormInterface $form;

    #[LiveAction]
    public function save(EntityManagerInterface $entityManager)
    {
        $this->validate();

        $this->isSaved = true;
        $entityManager->flush();
    }
}

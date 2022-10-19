<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Categorie;
use App\Form\AnnonceFormType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PublierController extends AbstractController
{
    #[Route('/publier/{type}', name: 'app_publier')]
    public function index(string $type): Response
    {
        $annonce = new Annonce();

        // $form = $this->createFormBuilder()
        //     ->add('imageFile1', DropzoneType::class, [
        //         'attr' => [
        //             'placeholder' => 'Photo principale',
        //         ],
        //         'label' => 'Image Annonce',
        //         'constraints' => [
        //             new Image(['maxSize' => '8M'])
        //         ]
        //     ])
        //     ->add('imageFile2', DropzoneType::class, [
        //         'attr' => [
        //             'placeholder' => 'Image 2',
        //         ],
        //         'label' => 'Image Annonce',
        //         'constraints' => [
        //             new Image(['maxSize' => '8M'])
        //         ]
        //     ])
        //     ->add('imageFile3', DropzoneType::class, [
        //         'attr' => [
        //             'placeholder' => 'Image 3',
        //         ],
        //         'label' => 'Image Annonce',
        //         'constraints' => [
        //             new Image(['maxSize' => '8M'])
        //         ]
        //     ])
        //     ->add('libelleAnnonce')
        //     ->add('description')
        //     ->add('prix', TextType::class, [
        //         'attr' => [
        //             'placeholder' => 'CFA',
        //         ],
        //     ])
        //     // ->add('sousCategorie', EntityType::class, [
        //     //     'class' => SousCategorie::class,
        //     //     'attr' => [
        //     //         'class' => 'input-block',
        //     //         'style' => 'display:contents;width: 300px'
        //     //     ],
        //     // ])
        //     // ->add('lienVideo')
        //     ->add('categorie', EntityType::class, [
        //         'class' => Categorie::class,
        //         'placeholder' => 'Choisissez une categorie',
        //     ])
        //     ->add('submit', SubmitType::class)
        //     ->getForm();
        $form = $this->createForm(AnnonceFormType::class, $annonce);

        return $this->renderForm('publier/index.html.twig', [
            'form' => $form,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Entity\SousCategorie;
use App\Repository\CategorieRepository;
use Symfony\UX\Dropzone\Form\DropzoneType;
use App\Repository\SousCategorieRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BoutiqueController extends AbstractController
{
    #[Route('/vendeur/boutique', name: 'app_boutique')]
    public function create(CategorieRepository $categorie, CategorieRepository $cateRepo): Response
    {
        return $this->render('boutique/index.html.twig', [
            'categories' => $cateRepo->findAll()
        ]);
    }

    #[Route('/vendeur/boutique/{libelle}', name: 'boutique_details')]
    public function after_categorie(Categorie $categorie, SousCategorieRepository $sousCatRepo): Response
    {
        $sousCategories =  $sousCatRepo->findByCountryOrderedByAscName($categorie);
        $form = $this->createFormBuilder()
            ->add('nomSalle', TextType::class, [
                'label' => "Nom Boutique"
            ])
            ->add('domaine', EntityType::class, [
                'class' => SousCategorie::class,
                'choices' => $sousCategories,
            ])
            ->add('imageFile', DropzoneType::class, [
                'attr' => [
                    'placeholder' => 'Faites drog et drop un fichier ou cliquez pour parcourir',
                ],
                'label' => 'Image Boutique',
                'constraints' => [
                    new Image(['maxSize' => '8M'])
                ]
            ])
            ->add('description', TextareaType::class)
            ->add('pays')
            ->add('ville')
            ->add('details', TextareaType::class)
            ->getForm();
        return $this->renderForm('boutique/details.html.twig', [
            'form' => $form
        ]);
    }
}

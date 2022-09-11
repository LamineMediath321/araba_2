<?php

namespace App\Controller;

use App\Entity\AdresseSalle;
use App\Entity\Categorie;
use App\Entity\SalleExposition;
use App\Entity\SousCategorie;
use App\Form\BoutiqueType;
use App\Repository\CategorieRepository;
use App\Repository\SalleExpositionRepository;
use Symfony\UX\Dropzone\Form\DropzoneType;
use App\Repository\SousCategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;

class BoutiqueController extends AbstractController
{
    #[Route('/vendeur/boutique', name: 'app_boutique')]
    public function create(CategorieRepository $cateRepo): Response
    {
        return $this->render('boutique/index.html.twig', [
            'categories' => $cateRepo->findAll()
        ]);
    }

    #[Route('/vendeur/boutique/{libelle}', name: 'boutique_details', methods: ['GET', 'POST'])]
    public function after_categorie(
        Categorie $categorie,
        SousCategorieRepository $sousCatRepo,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $sousCategories =  $sousCatRepo->findByCountryOrderedByAscName($categorie);
        $form = $this->createFormBuilder()
            ->add('nomSalle', TextType::class, [
                'label' => "Nom Boutique"
            ])
            ->add('domaine', EntityType::class, [
                'class' => SousCategorie::class,
                'choices' => $sousCategories,
                'autocomplete' => true,
                'placeholder' => 'chercher'
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
            ->add('pays', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('ville', TextType::class, [
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('details', TextareaType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $boutique = new SalleExposition;

            $boutique->setNomSalle($form->get('nomSalle')->getData());
            $boutique->setDescription($form->get('description')->getData() ?? '');
            $boutique->setDomaine($form->get('domaine')->getData());
            $boutique->setOwner($this->getUser());
            $image = $form->get('imageFile')->getData();

            if ($image != null) {
                // On génère un nouveau nom de fichier
                $fichier = $image->getClientOriginalName();
                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                // On crée l'image dans la base de données
                $boutique->setImageName($fichier);
            }
            $adresse = new AdresseSalle;
            $adresse->setPays($form->get('pays')->getData());
            $adresse->setVille($form->get('ville')->getData());
            $adresse->setDetails($form->get('details')->getData() ?? '');
            $adresse->setSalle($boutique);

            $manager->persist($adresse);
            $manager->persist($boutique);
            $manager->flush();

            return $this->redirectToRoute('boutique_info', [
                'boutique' => $boutique->getSlug()
            ]);
        }
        return $this->renderForm('boutique/details.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('vendeur/shop/details/{boutique}', name: 'boutique_info', methods: 'GET')]
    public function details_boutique(SalleExpositionRepository $boutiqueRepo, $boutique): Response
    {
        $boutique = $boutiqueRepo->findOneBy([
            'slug' => $boutique
        ]);
        $form = $this->createForm(BoutiqueType::class, $boutique);
        return $this->renderForm('boutique/boutique.html.twig', [
            'boutique' => $boutique,
            'form' => $form
        ]);
    }

    #[Route('/vendeur/shop/{boutique}', name: 'app_edit_image')]
    public function edit_image_boutique(
        SalleExposition $boutique,
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $form = $this->createForm(BoutiqueType::class, $boutique);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($boutique);
            $manager->flush();
            return $this->redirectToRoute('boutique_info', [
                'boutique' => $boutique->getSlug()
            ]);
        }
        return $this->renderForm('boutique/edit.html.twig', [
            'boutique' => $boutique,
            'form' => $form,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(CategorieRepository $cateRepo, AnnonceRepository $annoRepo): Response
    {
        return $this->render('home/index.html.twig', [
            'categories' => $cateRepo->findAll(),
            'all' => $annoRepo->findAllCategorieCime(),
            'immobiliers' => $annoRepo->findByCategorieCime('Immobilier'),
            'vehicules' => $annoRepo->findByCategorieCime('Véhicules'),
            'modes' => $annoRepo->findByCategorieCime('Mode'),
            'santes' => $annoRepo->findByCategorieCime('Santé, beauté, cosmétiques'),
        ]);
    }

    #[Route('/buy/{slug?}', name: 'app_buy')]
    public function buy(?string $slug, AnnonceRepository $annonRepo): Response
    {
        if (!$slug) {
            $annonces = $annonRepo->findAllAnnonces();
        }
        return $this->render('home/buy.html.twig', [
            'annonces' => $annonces
        ]);
    }

    #[Route('/produit-details/{slug}', name: 'app_details')]
    public function produit_details(Annonce $annonce, EntityManagerInterface $em, AnnonceRepository $annonRepo): Response
    {
        $annonce->setNbVus($annonce->getNbVus() + 1);
        $em->persist($annonce);
        $em->flush();
        $this->addFlash("error", "Cette annonce a eu " . $annonce->getNbVus() . " vus");
        return $this->render('home/produit_details.html.twig', [
            'annonce' => $annonce,
            'similaires' => $annonRepo->findBySimilaire($annonce->getSousCategorie(), $annonce->getId())
        ]);
    }
}

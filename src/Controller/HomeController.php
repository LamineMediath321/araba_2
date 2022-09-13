<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
use App\Repository\SousCategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        CategorieRepository $cateRepo,
        AnnonceRepository $annoRepo
    ): Response {
        return $this->render('home/index.html.twig', [
            'categories' => $cateRepo->findAll(),
            'all' => $annoRepo->findAllCategorieCime(),
            'immobiliers' => $annoRepo->findByCategorieCime('Immobilier'),
            'vehicules' => $annoRepo->findByCategorieCime('Véhicules'),
            'vetements' => $annoRepo->findByCategorieCime('Vetements'),
            'santes' => $annoRepo->findByCategorieCime('Santé, beauté, cosmétiques'),
        ]);
    }

    #[Route('/buy/{slug?}', name: 'app_buy')]
    public function buy(
        ?string $slug,
        AnnonceRepository $annonRepo,
        PaginatorInterface $paginator,
        Request $request,
        CategorieRepository $cateRepo,
        SousCategorieRepository $sousCateRepo,
    ): Response {
        if (!$slug) {
            $data = $annonRepo->findAllAnnonces();
            $tops = $annonRepo->findAllCategorieCime();
            $sousCategories = $cateRepo->findAll();
        } else {
            switch ($slug) {
                case 'Vehicules':
                    $data = $annonRepo->findByCategorieAll($slug);
                    $tops = $annonRepo->findBySousCategorieCime($slug);
                    $categorie = $cateRepo->findOneBy(['libelle' => $slug]);
                    $sousCategories = $categorie->getSousCategories();
                    break;
                case 'Immobilier':
                    $data = $annonRepo->findByCategorieAll($slug);
                    $tops = $annonRepo->findBySousCategorieCime($slug);
                    $categorie = $cateRepo->findOneBy(['libelle' => $slug]);
                    $sousCategories = $categorie->getSousCategories();
                    break;
                case 'Vetements':
                    $data = $annonRepo->findByCategorieAll($slug);
                    $tops = $annonRepo->findBySousCategorieCime($slug);
                    $categorie = $cateRepo->findOneBy(['libelle' => $slug]);
                    $sousCategories = $categorie->getSousCategories();
                    break;
                case 'Santé, beauté, cosmétiques':
                    $data = $annonRepo->findByCategorieAll($slug);
                    $tops = $annonRepo->findBySousCategorieCime($slug);
                    $categorie = $cateRepo->findOneBy(['libelle' => $slug]);
                    $sousCategories = $categorie->getSousCategories();
                    break;
                case 'Multimédia':
                    $data = $annonRepo->findByCategorieAll($slug);
                    $tops = $annonRepo->findBySousCategorieCime($slug);
                    $categorie = $cateRepo->findOneBy(['libelle' => $slug]);
                    $sousCategories = $categorie->getSousCategories();
                    break;
                case 'Foyer':
                    $data = $annonRepo->findByCategorieAll($slug);
                    $tops = $annonRepo->findBySousCategorieCime($slug);
                    $categorie = $cateRepo->findOneBy(['libelle' => $slug]);
                    $sousCategories = $categorie->getSousCategories();
                    break;
                case 'Sports':
                    $data = $annonRepo->findByCategorieAll($slug);
                    $tops = $annonRepo->findBySousCategorieCime($slug);
                    $categorie = $cateRepo->findOneBy(['libelle' => $slug]);
                    $sousCategories = $categorie->getSousCategories();
                    break;
                case "Offres d'Emploi":
                    $data = $annonRepo->findByCategorieAll($slug);
                    $tops = $annonRepo->findBySousCategorieCime($slug);
                    $categorie = $cateRepo->findOneBy(['libelle' => $slug]);
                    $sousCategories = $categorie->getSousCategories();
                    break;
                default:
                    $data = $annonRepo->findBySousCategorie($slug);
                    $tops = $annonRepo->findBySousCategorieCime($slug);
                    $sousCategorie = $sousCateRepo->findOneBy(['slug' => $slug]);
                    $categorie = $sousCategorie->getCategorie();
                    $sousCategories = $categorie->getSousCategories();
                    break;
            }
        }

        return $this->render('home/buy.html.twig', [
            'annonces' => $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                12
            ),
            'categories' => $cateRepo->findAll(),
            'tops' => $tops,
            'sousCategories' => $sousCategories ?? [],
        ]);
    }

    #[Route('/produit-details/{slug}', name: 'app_details')]
    public function produit_details(
        Annonce $annonce,
        EntityManagerInterface $em,
        AnnonceRepository $annonRepo
    ): Response {
        $annonce->setNbVus($annonce->getNbVus() + 1);
        $em->persist($annonce);
        $em->flush();
        $this->addFlash("success", "Cette annonce a eu " . $annonce->getNbVus() . " vues ✅");
        return $this->render('home/produit_details.html.twig', [
            'annonce' => $annonce,
            'similaires' => $annonRepo->findBySimilaire($annonce->getSousCategorie(), $annonce->getId())
        ]);
    }

    #[Route("/search", name: 'app_search')]
    public function search(): Response
    {
        return $this->render('home/search.html.twig');
    }
}

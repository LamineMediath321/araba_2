<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use App\Repository\CategorieRepository;
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
        CategorieRepository $cateRepo
    ): Response {
        if (!$slug) {
            $data = $annonRepo->findAllAnnonces();
            $tops = $annonRepo->findAllCategorieCime();
        } else {
            switch ($slug) {
                case 'Vehicules':
                    $data = $annonRepo->findByCategorieAll('Vehicules');
                    $tops = $annonRepo->findBySousCategorieCime('Vehicules');
                    break;
                case 'Immobilier':
                    $data = $annonRepo->findByCategorieAll('Immobilier');
                    $tops = $annonRepo->findBySousCategorieCime('Immobilier');
                    break;
                case 'Vetements':
                    $data = $annonRepo->findByCategorieAll('Vetements');
                    $tops = $annonRepo->findBySousCategorieCime('Vetements');
                    break;
                case 'Santé, beauté, cosmétiques':
                    $data = $annonRepo->findByCategorieAll('Santé, beauté, cosmétiques');
                    $tops = $annonRepo->findBySousCategorieCime('Santé, beauté, cosmétiques');
                    break;
                case 'Multimédia':
                    $data = $annonRepo->findByCategorieAll('Multimédia');
                    $tops = $annonRepo->findBySousCategorieCime('Multimédia');
                    break;
                case 'Foyer':
                    $data = $annonRepo->findByCategorieAll('Foyer');
                    $tops = $annonRepo->findBySousCategorieCime('Foyer');
                    break;
                case 'Sports':
                    $data = $annonRepo->findByCategorieAll('Sports');
                    $tops = $annonRepo->findBySousCategorieCime('Sports');
                    break;
                case "Offres d'Emploi":
                    $data = $annonRepo->findByCategorieAll("Offres d'Emploi");
                    $tops = $annonRepo->findBySousCategorieCime("Offres d'Emploi");
                    break;
                default:
                    $data = $annonRepo->findBySousCategorie($slug);
                    $tops = $annonRepo->findBySousCategorieCime($slug);
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
            'tops' => $tops
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

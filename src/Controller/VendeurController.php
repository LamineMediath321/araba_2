<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VendeurController extends AbstractController
{
    #[Route('/vendeur', name: 'app_vendeur')]
    public function index(
        AnnonceRepository $annoRepo,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $data = $annoRepo->findBy(
            ['user' => $this->getUser()],
            ['createdAt' => 'DESC']
        );
        return $this->render('vendeur/index.html.twig', [
            'annonces' => $paginator->paginate(
                $data,
                $request->query->getInt('page', 1),
                12
            ),
            'enVente' => $annoRepo->countAnnoncesByUserEnVendu($this->getUser()) ?? 0,
            'vendu' => $annoRepo->countAnnoncesByUserVendu($this->getUser()) ?? 0,
            'expire' => $annoRepo->countAnnoncesByUserExpire($this->getUser()) ?? 0,
            'noPaye' => $annoRepo->countAnnoncesByUserNoPaye($this->getUser()) ?? 0,
        ]);
    }

    #[Route('vendeur/vendu/{slug}', name: 'app_vendu')]
    public function vendu(
        Annonce $annonce,
        EntityManagerInterface $manager
    ): Response {
        if ($annonce->isIsVendu() == true)
            $annonce->setIsVendu(false);
        else $annonce->setIsVendu(true);

        $manager->persist($annonce);
        $manager->flush();
        if ($annonce->isIsVendu() == true)
            $this->addFlash("success", "Félicitations 👏 vous avez vendu " . $annonce->getLibelleAnnonce());
        else
            $this->addFlash("info", $annonce->getLibelleAnnonce() . " est de nouveau en vente");
        return $this->redirectToRoute('app_vendeur');
    }
}

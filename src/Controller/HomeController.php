<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig');
    }

    #[Route('/buy', name: 'app_buy')]
    public function buy(): Response
    {
        return $this->render('home/buy.html.twig');
    }

    #[Route('/produit-details', name: 'app_details')]
    public function produit_details(): Response
    {
        return $this->render('home/produit_details.html.twig');
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SellerController extends AbstractController
{
    #[Route('/seller', name: 'seller_index')]
    public function index(): Response
    {
        return $this->render('seller/index.html.twig', [
            'controller_name' => 'SellerController',
        ]);
    }

    #[Route('/sellerProfile', name: 'seller_profile')]
    public function profile(): Response
    {
        return $this->render('seller/profile.html.twig', [
            'controller_name' => 'SellerController',
        ]);
    }

    #[Route('/sellerMyannonces', name: 'seller_annonces')]
    public function annonces(): Response
    {
        return $this->render('seller/myannonces.html.twig', [
            'controller_name' => 'SellerController',
        ]);
    }
}

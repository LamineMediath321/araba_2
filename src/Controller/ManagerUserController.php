<?php

namespace App\Controller;

use App\Entity\AdresseUser;
use App\Entity\InfoPerso;
use App\Form\AdresseUserType;
use App\Form\InfoPersoType;
use App\Form\UserEditType;
use App\Repository\AdresseUserRepository;
use App\Repository\InfoPersoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManagerUserController extends AbstractController
{
    #[Route('/vendeur/edit', name: 'app_user')]
    public function index(
        EntityManagerInterface $manager,
        Request $request
    ): Response {
        $user = $this->getUser();
        $form = $this->createForm(UserEditType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            $this->addFlash("success", "Mise à jour avec success");
            $this->redirectToRoute('app_vendeur');
        }

        return $this->renderForm('manager_user/edit.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/vendeur/edit/info', name: 'app_user_info')]
    public function edit_info(
        EntityManagerInterface $manager,
        Request $request,
        InfoPersoRepository $infoRepo
    ): Response {
        $user = $this->getUser();
        $infoPerso = $infoRepo->findOneBy([
            'user' => $user
        ]);
        if (!$infoPerso) {
            $infoPerso = new InfoPerso();
        }
        $form = $this->createForm(InfoPersoType::class, $infoPerso);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $infoPerso->setUser($user);
            $manager->persist($infoPerso);
            $manager->flush();
            $this->addFlash("success", "Mise à jour avec success");
            $this->redirectToRoute('app_vendeur');
        }

        return $this->renderForm('manager_user/edit_info.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/vendeur/edit/adresse', name: 'app_user_adresse')]
    public function edit_adresse(
        EntityManagerInterface $manager,
        Request $request,
        AdresseUserRepository $adresseRepo
    ): Response {
        $user = $this->getUser();
        $adresse = $adresseRepo->findOneBy([
            'user' => $user
        ]);
        if (!$adresse) {
            $adresse = new AdresseUser();
        }
        $form = $this->createForm(AdresseUserType::class, $adresse);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $adresse->setUser($user);
            $manager->persist($adresse);
            $manager->flush();
            $this->addFlash("success", "Mise à jour avec success");
            $this->redirectToRoute('app_vendeur');
        }

        return $this->renderForm('manager_user/edit_adresse.html.twig', [
            'form' => $form,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Annonce;
use App\Entity\Like;
use App\Repository\LikeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FavorisController extends AbstractController
{
    #[Route('/favoris/{slug}', name: 'app_favoris')]
    public function annonce_like(
        Annonce $annonce,
        EntityManagerInterface $em,
        LikeRepository $likeRepo
    ): Response {
        $user = $this->getUser();
        if (!$user) {
            return $this->json([
                'code' => 403,
                'message' => 'Unauthorized'
            ], 403);
        }
        if ($annonce->isLikedByUser($user)) {
            $like = $likeRepo->findOneBy([
                'annonce' => $annonce,
                'user' => $user
            ]);
            $em->remove($like);
            $em->flush();

            return $this->json([
                'code' => 200,
                'message' => 'Like bien supprimé',
                'likes' => $likeRepo->count(['annonce' => $annonce])
            ], 200);
        }

        $like = new Like();
        $like->setannonce($annonce);
        $like->setUser($user);

        $em->persist($like);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => 'like bien ajouté',
            'likes' => $likeRepo->count(['annonce' => $annonce])
        ], 200);
    }
}

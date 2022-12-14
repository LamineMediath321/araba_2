<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Entity\SousCategorie;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Annonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method Annonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method Annonce[]    findAll()
 * @method Annonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Annonce::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Annonce $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(Annonce $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Annonce[] Returns an array of Annonce objects
    //  */

    //POur les Categirie Top annonces
    public function findByCategorieCime($libelle)
    {
        //Le limmite à 10 pourrais changer
        $query = $this->createQueryBuilder('a');
        $query->leftJoin('a.sousCategorie', 's');
        $query->leftJoin('s.categorie', 'c');
        $query->andWhere('c.libelle = :libelle');
        $query->andWhere('a.isPaye = true');
        $query->andWhere('a.isCime = true');
        $query->andWhere('a.isVendu = false');
        $query->andWhere('a.isUptodate = true');
        $query->setParameter('libelle', $libelle);
        $query->setMaxResults(10);

        return $query->getQuery()->getResult();
    }

    //Toutes les annonces par categories
    public function findByCategorieAll($libelle)
    {
        //Le limmite à 10 pourrais changer
        $query = $this->createQueryBuilder('a');
        $query->leftJoin('a.sousCategorie', 's');
        $query->leftJoin('s.categorie', 'c');
        $query->andWhere('c.libelle = :libelle');
        $query->andWhere('a.isPaye = true');
        $query->andWhere('a.isCime = true');
        $query->andWhere('a.isVendu = false');
        $query->andWhere('a.isUptodate = true');
        $query->setParameter('libelle', $libelle);
        return $query->getQuery()->getResult();
    }

    //Toutes les Annonces par sousCategorie
    public function findBySousCategorie($slug)
    {
        //Le limmite à 10 pourrais changer
        $query = $this->createQueryBuilder('a');
        $query->andWhere('a.isPaye = true');
        $query->andWhere('a.isVendu = false');
        $query->andWhere('a.isUptodate = true');
        $query->leftJoin('a.sousCategorie', 's');
        $query->andWhere('s.slug = :slug');
        $query->setParameter('slug', $slug);

        return $query->getQuery()->getResult();
    }

    //Toutes les Annonces par sousCategorie
    public function findBySousCategorieCime($slug)
    {
        //Le limmite à 10 pourrais changer
        $query = $this->createQueryBuilder('a');
        $query->andWhere('a.isPaye = true');
        $query->andWhere('a.isVendu = false');
        $query->andWhere('a.isCime = true');
        $query->andWhere('a.isUptodate = true');
        $query->leftJoin('a.sousCategorie', 's');
        $query->andWhere('s.slug = :slug');
        $query->setParameter('slug', $slug);

        return $query->getQuery()->getResult();
    }

    public function findAllCategorieCime()
    {
        //Le limmite à 10 pourrais changer
        $query = $this->createQueryBuilder('a');
        $query->andWhere('a.isPaye = true');
        $query->andWhere('a.isCime = true');
        $query->andWhere('a.isVendu = false');
        $query->andWhere('a.isUptodate = true');
        $query->orderBy('a.createdAt', 'DESC');
        $query->setMaxResults(10);

        return $query->getQuery()->getResult();
    }

    //Les dernieres annonces
    public function findAllAnnonces()
    {
        //Le limmite à 10 pourrais changer
        $query = $this->createQueryBuilder('a');
        $query->andWhere('a.isPaye = true');
        $query->andWhere('a.isVendu = false');
        $query->andWhere('a.isUptodate = true');
        $query->orderBy('a.createdAt', 'DESC');
        // $query->setMaxResults(12);

        return $query->getQuery()->getResult();
    }


    //Pour les annonces similaires
    public function findBySimilaire(SousCategorie $sousCategorie, int $id)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.sousCategorie = :sousCategorie')
            ->setParameter('sousCategorie', $sousCategorie)
            ->andWhere('a.id != :id')
            ->setParameter('id', $id)
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    //Les annonces propres au user
    public function countAnnoncesByUserEnVendu($user)
    {
        $query = $this->createQueryBuilder('a');
        $query->select("COUNT(a) as enVente");
        $query->andWhere('a.isPaye = true');
        $query->andWhere('a.user = :user');
        $query->andWhere('a.isUptodate = true');
        $query->andWhere('a.isVendu = false');
        $query->setParameter('user', $user);

        return $query->getQuery()->getSingleScalarResult();
    }
    public function countAnnoncesByUserVendu($user)
    {
        $query = $this->createQueryBuilder('a');
        $query->select("COUNT(a) as enVente");
        $query->andWhere('a.isPaye = true');
        $query->andWhere('a.user = :user');
        $query->andWhere('a.isVendu = true');
        $query->setParameter('user', $user);

        return $query->getQuery()->getSingleScalarResult();
    }
    public function countAnnoncesByUserExpire($user)
    {
        $query = $this->createQueryBuilder('a');
        $query->select("COUNT(a) as enVente");
        $query->andWhere('a.isPaye = true');
        $query->andWhere('a.user = :user');
        $query->andWhere('a.isUptodate = false');
        $query->setParameter('user', $user);

        return $query->getQuery()->getSingleScalarResult();
    }
    public function countAnnoncesByUserNoPaye($user)
    {
        $query = $this->createQueryBuilder('a');
        $query->select("COUNT(a) as enVente");
        $query->andWhere('a.isPaye = false');
        $query->andWhere('a.user = :user');
        $query->setParameter('user', $user);

        return $query->getQuery()->getSingleScalarResult();
    }
    public function findAllAnnoncesByuserCime($user)
    {
        $query = $this->createQueryBuilder('a');
        $query->andWhere('a.isPaye = true');
        $query->andWhere('a.isCime = true');
        $query->andWhere('a.user = :user');
        $query->orderBy('a.createdAt', 'DESC');
        $query->setParameter('user', $user);

        return $query->getQuery()->getResult();
    }

    //End of user


    public function search($query)
    {
        if (empty($query)) {
            return [];
        }

        return $this->createQueryBuilder('a')
            ->andWhere('a.libelleAnnonce LIKE :query')
            ->setParameter('query', '%' . $query . '%')
            ->orderBy('a.id', 'ASC')
            ->getQuery()
            ->getResult();
    }
}

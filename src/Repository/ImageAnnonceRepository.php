<?php

namespace App\Repository;

use App\Entity\ImageAnnonce;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ImageAnnonce|null find($id, $lockMode = null, $lockVersion = null)
 * @method ImageAnnonce|null findOneBy(array $criteria, array $orderBy = null)
 * @method ImageAnnonce[]    findAll()
 * @method ImageAnnonce[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ImageAnnonceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ImageAnnonce::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(ImageAnnonce $entity, bool $flush = true): void
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
    public function remove(ImageAnnonce $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return ImageAnnonce[] Returns an array of ImageAnnonce objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('i.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ImageAnnonce
    {
        return $this->createQueryBuilder('i')
            ->andWhere('i.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

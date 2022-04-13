<?php

namespace App\Repository;

use App\Entity\Ouverage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ouverage|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ouverage|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ouverage[]    findAll()
 * @method Ouverage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OuverageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ouverage::class);
    }

    public function findAllQueryBuilder()
    {
        $qb = $this->createQueryBuilder('c');
        return $qb->getQuery();
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Ouverage $entity, bool $flush = true): void
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
    public function remove(Ouverage $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }


    // /**
    //  * @return Ouverage[] Returns an array of Ouverage objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Ouverage
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}

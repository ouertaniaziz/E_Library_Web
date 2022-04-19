<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Users|null find($idg, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(Users $entity, bool $flush = true): void
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
    public function remove(Users $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    // /**
    //  * @return Users[] Returns an array of Users objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.idg', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    public function findByEmail(String $value, String $v)
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :val')
            ->andWhere('u.password = :vall')
            ->setParameter('val', $value)
            ->setParameter('vall', $v)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findByEmailA(String $value)
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :val')
            ->setParameter('val', $value)
            ->setMaxResults(1)
            ->getQuery()
            ->getResult()
            ;
    }
    public function listByOrder()
    {
        return $this->createQueryBuilder('u')
            ->orderBy('u.idUser','DESC')
            ->getQuery()
            ->getResult();
    }
    public function findPersonnel()
    {
        return $this->createQueryBuilder('u')
            ->where('u.role = :val')
            ->setParameter('val', 3)
            ->getQuery()
            ->getResult();
    }
    public function findClient()
    {
        return $this->createQueryBuilder('u')
            ->where('u.role = :val')
            ->setParameter('val', 1)
            ->getQuery()
            ->getResult();
    }


    /*
    public function findOneBySomeField($value): ?USers
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
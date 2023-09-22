<?php

namespace App\Repository;

use App\Entity\Bullet;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Bullet>
 *
 * @method Bullet|null find($id, $lockMode = null, $lockVersion = null)
 * @method Bullet|null findOneBy(array $criteria, array $orderBy = null)
 * @method Bullet[]    findAll()
 * @method Bullet[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BulletRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Bullet::class);
    }

//    /**
//     * @return Bullet[] Returns an array of Bullet objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Bullet
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

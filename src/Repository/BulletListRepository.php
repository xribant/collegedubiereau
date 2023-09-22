<?php

namespace App\Repository;

use App\Entity\BulletList;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<BulletList>
 *
 * @method BulletList|null find($id, $lockMode = null, $lockVersion = null)
 * @method BulletList|null findOneBy(array $criteria, array $orderBy = null)
 * @method BulletList[]    findAll()
 * @method BulletList[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BulletListRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BulletList::class);
    }

//    /**
//     * @return BulletList[] Returns an array of BulletList objects
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

//    public function findOneBySomeField($value): ?BulletList
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

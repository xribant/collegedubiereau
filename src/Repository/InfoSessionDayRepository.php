<?php

namespace App\Repository;

use App\Entity\InfoSessionDay;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InfoSessionDay>
 *
 * @method InfoSessionDay|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoSessionDay|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoSessionDay[]    findAll()
 * @method InfoSessionDay[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoSessionDayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoSessionDay::class);
    }

//    /**
//     * @return InfoSessionDay[] Returns an array of InfoSessionDay objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InfoSessionDay
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\StandardPage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StandardPage>
 *
 * @method StandardPage|null find($id, $lockMode = null, $lockVersion = null)
 * @method StandardPage|null findOneBy(array $criteria, array $orderBy = null)
 * @method StandardPage[]    findAll()
 * @method StandardPage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class StandardPageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, StandardPage::class);
    }

//    /**
//     * @return StandardPage[] Returns an array of StandardPage objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('s.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?StandardPage
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

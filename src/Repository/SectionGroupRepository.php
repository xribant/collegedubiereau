<?php

namespace App\Repository;

use App\Entity\SectionGroup;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<SectionGroup>
 *
 * @method SectionGroup|null find($id, $lockMode = null, $lockVersion = null)
 * @method SectionGroup|null findOneBy(array $criteria, array $orderBy = null)
 * @method SectionGroup[]    findAll()
 * @method SectionGroup[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionGroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, SectionGroup::class);
    }

    public function findByPosition(): array
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.position', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }

//    /**
//     * @return SectionGroup[] Returns an array of SectionGroup objects
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

//    public function findOneBySomeField($value): ?SectionGroup
//    {
//        return $this->createQueryBuilder('s')
//            ->andWhere('s.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

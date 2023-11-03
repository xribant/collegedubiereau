<?php

namespace App\Repository;

use App\Entity\InfoRegistration;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InfoRegistration>
 *
 * @method InfoRegistration|null find($id, $lockMode = null, $lockVersion = null)
 * @method InfoRegistration|null findOneBy(array $criteria, array $orderBy = null)
 * @method InfoRegistration[]    findAll()
 * @method InfoRegistration[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InfoRegistrationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InfoRegistration::class);
    }

//    /**
//     * @return InfoRegistration[] Returns an array of InfoRegistration objects
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

//    public function findOneBySomeField($value): ?InfoRegistration
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

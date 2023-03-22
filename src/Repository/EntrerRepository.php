<?php

namespace App\Repository;

use App\Entity\Entrer;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Entrer>
 *
 * @method Entrer|null find($id, $lockMode = null, $lockVersion = null)
 * @method Entrer|null findOneBy(array $criteria, array $orderBy = null)
 * @method Entrer[]    findAll()
 * @method Entrer[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntrerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Entrer::class);
    }

    public function save(Entrer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Entrer $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getExpensesByYear($startDate, $endDate)
    {
        return $this->createQueryBuilder('e')
        ->select('SUM(e.quantity)')
        ->where('e.date BETWEEN :start AND :end')
        ->setParameter('start', $startDate)
        ->setParameter('end', $endDate)
        ->getQuery()
        ->getSingleScalarResult();
    }

    public function getRevenuAverageThisMonth($startDate, $endDate){
        return $this->createQueryBuilder('e')
        ->select('AVG(e.quantity) as AE, e.date as month')
        ->where('e.date BETWEEN :start AND :end')
        ->groupBy('month') 
        ->orderBy('month', 'ASC')
        ->setParameter('start', $startDate)
        ->setParameter('end', $endDate)
        ->getQuery()
        ->getResult();
    }



//    /**
//     * @return Entrer[] Returns an array of Entrer objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('e.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Entrer
//    {
//        return $this->createQueryBuilder('e')
//            ->andWhere('e.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

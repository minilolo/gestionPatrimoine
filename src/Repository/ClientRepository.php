<?php

namespace App\Repository;

use App\Entity\Client;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 *
 * @method Client|null find($id, $lockMode = null, $lockVersion = null)
 * @method Client|null findOneBy(array $criteria, array $orderBy = null)
 * @method Client[]    findAll()
 * @method Client[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function save(Client $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Client $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function findByFullName($nom, $prenom){
        return $this->createQueryBuilder('u')
            ->where('u.nom = :name')
            ->andWhere('u.prenom = :firstname')
            ->setParameter('name', $nom)
            ->setParameter('firstname', $prenom)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function countAll()
    {
        return $this->createQueryBuilder('s')
            ->select('count(s.id)')
            
            
            ->getQuery()->getSingleScalarResult();
    }

    public function countAllActive()
    {
        return $this->createQueryBuilder('s')
            ->select('count(s.id)')
            ->andWhere('s.status = 1')

            
            
            ->getQuery()->getSingleScalarResult();
    }

    public function countCredit(){
        return $this->createQueryBuilder('s')
        ->select('sum(s.montant)')
        
        
        ->getQuery()->getSingleScalarResult();
    }

//    /**
//     * @return Client[] Returns an array of Client objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Client
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

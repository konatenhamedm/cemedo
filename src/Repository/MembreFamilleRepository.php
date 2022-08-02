<?php

namespace App\Repository;

use App\Entity\MembreFamille;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MembreFamille>
 *
 * @method MembreFamille|null find($id, $lockMode = null, $lockVersion = null)
 * @method MembreFamille|null findOneBy(array $criteria, array $orderBy = null)
 * @method MembreFamille[]    findAll()
 * @method MembreFamille[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MembreFamilleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MembreFamille::class);
    }

    public function add(MembreFamille $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MembreFamille $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }


    public function getFamille($value): array
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.assure = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getResult()
        ;
    }
    public function getLastMembre(){
        return $this->createQueryBuilder("d")
            ->select("max(d.id) as id")
            ->getQuery()
            ->getSingleScalarResult();
    }


//    /**
//     * @return MembreFamille[] Returns an array of MembreFamille objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MembreFamille
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

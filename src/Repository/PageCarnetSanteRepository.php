<?php

namespace App\Repository;

use App\Entity\PageCarnetSante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PageCarnetSante>
 *
 * @method PageCarnetSante|null find($id, $lockMode = null, $lockVersion = null)
 * @method PageCarnetSante|null findOneBy(array $criteria, array $orderBy = null)
 * @method PageCarnetSante[]    findAll()
 * @method PageCarnetSante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageCarnetSanteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PageCarnetSante::class);
    }

    public function add(PageCarnetSante $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PageCarnetSante $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PageCarnetSante[] Returns an array of PageCarnetSante objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PageCarnetSante
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

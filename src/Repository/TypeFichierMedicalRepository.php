<?php

namespace App\Repository;

use App\Entity\TypeFichierMedical;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TypeFichierMedical>
 *
 * @method TypeFichierMedical|null find($id, $lockMode = null, $lockVersion = null)
 * @method TypeFichierMedical|null findOneBy(array $criteria, array $orderBy = null)
 * @method TypeFichierMedical[]    findAll()
 * @method TypeFichierMedical[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TypeFichierMedicalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TypeFichierMedical::class);
    }

    public function add(TypeFichierMedical $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(TypeFichierMedical $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return TypeFichierMedical[] Returns an array of TypeFichierMedical objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('t.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?TypeFichierMedical
//    {
//        return $this->createQueryBuilder('t')
//            ->andWhere('t.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

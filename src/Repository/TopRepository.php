<?php

namespace App\Repository;

use App\Entity\Top;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Top>
 */
class TopRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Top::class);
    }

    public function findAllFilleuls(int $topId){
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT f
             FROM App\Entity\Filleul f
             JOIN f.parrain p
             JOIN p.top t
             WHERE t.id = :topId
             ORDER BY f.nom ASC' // Tri par nom dans l'ordre croissant
        )->setParameter('topId', $topId);
    
        return $query->getResult();
    }

    //    /**
    //     * @return Top[] Returns an array of Top objects
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

    //    public function findOneBySomeField($value): ?Top
    //    {
    //        return $this->createQueryBuilder('t')
    //            ->andWhere('t.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

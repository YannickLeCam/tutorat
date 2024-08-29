<?php

namespace App\Repository;

use App\Entity\Direction;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Direction>
 */
class DirectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Direction::class);
    }
    
    public function searchDirections(array $criteria): array
    {
        $qb = $this->createQueryBuilder('d');
    
        if (!empty($criteria['nom'])) {
            $qb->andWhere('d.nom LIKE :nom')
               ->setParameter('nom', '%' . $criteria['nom'] . '%');
        }
    
        if (!empty($criteria['prenom'])) {
            $qb->andWhere('d.prenom LIKE :prenom')
               ->setParameter('prenom', '%' . $criteria['prenom'] . '%');
        }
    
        if (!empty($criteria['faculte'])) {
            $qb->andWhere('d.faculte = :faculte')
               ->setParameter('faculte', $criteria['faculte']);
        }
    
        return $qb->getQuery()->getResult();
    }
    
    //    /**
    //     * @return Direction[] Returns an array of Direction objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('d.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Direction
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

<?php

namespace App\Repository;

use App\Entity\Parrain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Parrain>
 */
class ParrainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Parrain::class);
    }

        public function searchParrains(array $criteria): array
        {
            $qb = $this->createQueryBuilder('p');

            if (!empty($criteria['nom'])) {
                $qb->andWhere('p.nom LIKE :nom')
                ->setParameter('nom', '%' . $criteria['nom'] . '%');
            }

            if (!empty($criteria['prenom'])) {
                $qb->andWhere('p.prenom LIKE :prenom')
                ->setParameter('prenom', '%' . $criteria['prenom'] . '%');
            }

            if (!empty($criteria['top'])) {
                $qb->andWhere('p.top = :top')
                ->setParameter('top', $criteria['top']);
            }

            if (!empty($criteria['faculte'])) {
                $qb->andWhere('p.faculte = :faculte')
                ->setParameter('faculte', $criteria['faculte']);
            }

            return $qb->getQuery()->getResult();
        }


    //    /**
    //     * @return Parrain[] Returns an array of Parrain objects
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

    //    public function findOneBySomeField($value): ?Parrain
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

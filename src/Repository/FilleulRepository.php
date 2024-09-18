<?php

namespace App\Repository;

use App\Entity\Filleul;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Filleul>
 */
class FilleulRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Filleul::class);
    }

    public function searchFilleuls(array $criteria): array
    {
        $qb = $this->createQueryBuilder('f');

        if (!empty($criteria['nom'])) {
            $qb->andWhere('f.nom LIKE :nom')
                ->setParameter('nom', '%' . $criteria['nom'] . '%');
        }

        if (!empty($criteria['prenom'])) {
            $qb->andWhere('f.prenom LIKE :prenom')
                ->setParameter('prenom', '%' . $criteria['prenom'] . '%');
        }

        if (!empty($criteria['mail'])) {
            $qb->andWhere('f.mail LIKE :mail')
                ->setParameter('mail', '%' . $criteria['mail'] . '%');
        }

        if (!empty($criteria['telephone'])) {
            $qb->andWhere('f.telephone LIKE :telephone')
                ->setParameter('telephone', '%' . $criteria['telephone'] . '%');
        }

        if (!empty($criteria['mineure'])) {
            $qb->andWhere('f.mineure = :mineure')
                ->setParameter('mineure', $criteria['mineure']);
        }

        if (!empty($criteria['specialite'])) {
            $qb->andWhere('f.specialite = :specialite')
                ->setParameter('specialite', $criteria['specialite']);
        }

        if (!empty($criteria['parrain'])) {
            $qb->andWhere('f.parrain = :parrain')
                ->setParameter('parrain', $criteria['parrain']);
        }

        if (!empty($criteria['faculte'])) {
            $qb->andWhere('f.faculte = :faculte')
                ->setParameter('faculte', $criteria['faculte']);
        }

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Filleul[] Returns an array of Filleul objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('f.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Filleul
//    {
//        return $this->createQueryBuilder('f')
//            ->andWhere('f.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

<?php

namespace App\Repository;

use App\Entity\Festival;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Festival>
 */
class FestivalRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Festival::class);
    }

    public function findFestivalsOnPage(EntityManagerInterface $entityManager, $search, string $sort, int $limit, int $offset): array
    {
        $query = $this->createCustomQuery($entityManager, $search, $sort, $offset);

        $query->setFirstResult($offset)
            ->setMaxResults($limit);

        return $query->getResult();
    }

    public function createCustomQuery(EntityManagerInterface $entityManager, $search, string $sort): \Doctrine\ORM\Query
    {
        $query = $entityManager->createQueryBuilder();
        $query->select('f')
            ->from(Festival::class, 'f');

        if ('' != $search) {
            $query->where($query->expr()->like('f.name', ':search'))
                ->setParameter('search', '%' . $search . '%');
        }

        if ('' != $sort) {
            $query->orderBy('f.' . $sort, 'ASC');
        }

        return $query->getQuery();
    }

    public function findTotalFestivals(EntityManagerInterface $entityManager, string $search, string $sort, int $limit, int $offset): int
    {
        $query = $this->createCustomQuery($entityManager, $search, $sort);

        return count($query->getResult());
    }

    //    /**
    //     * @return Festival[] Returns an array of Festival objects
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

    //    public function findOneBySomeField($value): ?Festival
    //    {
    //        return $this->createQueryBuilder('f')
    //            ->andWhere('f.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

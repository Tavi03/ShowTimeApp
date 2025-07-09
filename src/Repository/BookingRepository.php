<?php

namespace App\Repository;

use App\Entity\Booking;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Booking>
 */
class BookingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Booking::class);
    }

    //TODO: Add booking date and time and sorting system for it
    public function findBookings(string $search, string $sort): array
    {
        $query = $this->createQueryBuilder('b');

        if ($search) {
            $query->where('b.fullName LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        if ($sort == 'fullNameAscending') {
            $query->orderBy('b.fullName', 'ASC');
        } else if ($sort == 'fullNameDescending') {
            $query->orderBy('b.fullName', 'DESC');
        }

        return $query->getQuery()->getResult();
    }

//    /**
//     * @return Booking[] Returns an array of Booking objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('b.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Booking
//    {
//        return $this->createQueryBuilder('b')
//            ->andWhere('b.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}

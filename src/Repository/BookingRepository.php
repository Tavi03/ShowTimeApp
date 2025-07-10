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

    public function findBookings(string $search, string $sort): array
    {
        $query = $this->createQueryBuilder('b');

        if ($search) {
            $query->where('b.fullName LIKE :search')
                ->setParameter('search', '%' . $search . '%');
        }

        switch ($sort) {
            case 'fullNameAscending':
                $query->orderBy('b.fullName', 'ASC');
                break;
            case 'fullNameDescending':
                $query->orderBy('b.fullName', 'DESC');
                break;
            case 'bookingDateAscending':
                $query->orderBy('b.bookedAt', 'ASC');
                break;
            case 'bookingDateDescending':
                $query->orderBy('b.bookedAt', 'DESC');
                break;
            default:
                $query->orderBy('b.id', 'ASC');
                break;
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

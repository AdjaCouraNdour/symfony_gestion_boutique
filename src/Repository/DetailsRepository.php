<?php

namespace App\Repository;

use App\Entity\Details;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepositoryDetails>
 */
class DetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry,Details::class);
    }

    //    /**
    //     * @returnDetails[] Returns an array ofDetails objects
    //     */
       public function paginatDetails(int $page ,int $limit): Paginator
       {
           $query = $this->createQueryBuilder('c')
               ->setFirstResult(( $page - 1 ) * $limit)
               ->setMaxResults($limit)
               ->orderBy('c.id', 'ASC')
               ->getQuery();
            return new Paginator($query);
       }

    //    public function findOneBySomeField($value): Details
    //    {
    //        return $this->createQueryBuilder('c')
    //            ->andWhere('c.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}

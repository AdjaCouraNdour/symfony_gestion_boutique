<?php

namespace App\Repository;

use App\Entity\Dette;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\Tools\Pagination\Paginator;

/**
 * @extends ServiceEntityRepository<Dette>
 */
class DetteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Dette::class);
    }

    public function paginateDette(int $page ,int $limit): Paginator
    {
        $query = $this->createQueryBuilder('c')
            ->setFirstResult(( $page - 1 ) * $limit)
            ->setMaxResults($limit)
            ->orderBy('c.id', 'ASC')
            ->getQuery();
         return new Paginator($query);
    }


    public function findDettesByClientId(int $clientId)
    {
        return $this->createQueryBuilder('c')
            ->leftJoin('c.dettes', 'd')
            ->addSelect('d')
            ->leftJoin('d.details', 'de')
            ->addSelect('de')
            ->leftJoin('de.article', 'a')
            ->addSelect('a')
            ->andWhere('c.id = :id')
            ->setParameter('id', $clientId)
            ->getQuery()
            ->getResult();
    }

    //    /**
    //     * @return Dette[] Returns an array of Dette objects
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

    //    public function findOneBySomeField($value): ?Dette
    //    {
    //        return $this->createQueryBuilder('d')
    //            ->andWhere('d.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
